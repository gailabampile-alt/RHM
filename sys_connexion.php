<?php
    if (!function_exists('app_env')) {
        function app_env($name, $default = '')
        {
            $value = getenv($name);
            return $value === false ? $default : $value;
        }
    }

    if (!class_exists('AppPDO', false)) {
        class AppPDO extends PDO
        {
            private $schemaName;

            public function __construct($dsn, $username, $password, $options, $schemaName)
            {
                $this->schemaName = $schemaName;
                parent::__construct($dsn, $username, $password, $options);
            }

            private function qualifySql($statement)
            {
                if ($this->schemaName === '' || $this->schemaName === 'bdd_paie') {
                    return $statement;
                }

                $schema = '`' . str_replace('`', '``', $this->schemaName) . '`';
                return str_replace(array('`bdd_paie`.', 'bdd_paie.'), $schema . '.', $statement);
            }

            #[\ReturnTypeWillChange]
            public function prepare($statement, $options = array())
            {
                return parent::prepare($this->qualifySql($statement), $options);
            }

            #[\ReturnTypeWillChange]
            public function query($statement, $mode = null, ...$fetchModeArgs)
            {
                $statement = $this->qualifySql($statement);

                if ($mode === null) {
                    return parent::query($statement);
                }

                return parent::query($statement, $mode, ...$fetchModeArgs);
            }

            #[\ReturnTypeWillChange]
            public function exec($statement)
            {
                return parent::exec($this->qualifySql($statement));
            }
        }
    }

    $dbHost = app_env('DB_HOST', 'localhost');
    $dbPort = app_env('DB_PORT');
    $dbName = app_env('DB_NAME', 'bdd_paie');
    $dbSchema = app_env('DB_SCHEMA', $dbName);
    $dbUser = app_env('DB_USER', 'root');
    $dbPassword = app_env('DB_PASS', '');
    $dbCharset = app_env('DB_CHARSET', 'utf8');

    $dsn = 'mysql:dbname=' . $dbName . ';host=' . $dbHost . ';charset=' . $dbCharset;
    if ($dbPort !== '') {
        $dsn .= ';port=' . $dbPort;
    }

    try {
        $db = new AppPDO(
            $dsn,
            $dbUser,
            $dbPassword,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ),
            $dbSchema
        );
    } catch (PDOException $e) {
        error_log('[HRM] Connexion BD impossible: ' . $e->getMessage());

        if (function_exists('session_status') && session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }

        if (function_exists('session_status') && session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['message'] = 'Connexion a la base de donnees impossible. Verifiez les parametres MySQL du serveur.';
            $_SESSION['typeMsg'] = 'danger';
        }

        if (!headers_sent()) {
            header('location:index.php');
            exit();
        }

        echo 'Connexion a la base de donnees impossible.';
        exit();
    }
?>
