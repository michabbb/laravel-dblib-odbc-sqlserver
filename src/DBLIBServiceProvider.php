<?php

namespace DblibOdbcSqlServer\Database;

use Illuminate\Support\ServiceProvider;

class DBLIBServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function register() {
		return [];
	}

	public function provides() {
		return [];
	}

	public function boot() {
		$factory = $this->app['db'];
		$factory->extend('odbc', function ($config) {
			if (!isset($config['prefix'])) {
				$config['prefix'] = '';
			}
			$connector = new ODBCConnector();
			$pdo       = $connector->connect($config);
			$db        = new ODBCConnection($pdo, $config['database'], $config['prefix']);

			return $db;
		});

		$factory->extend('dblib', function ($config) {
			if (!isset($config['prefix'])) {
				$config['prefix'] = '';
			}
			$connector = new DBLIBConnector();
			$pdo       = $connector->connect($config);
			$db        = new DBLIBConnection($pdo, $config['database'], $config['prefix']);

			return $db;
		});

	}

}
