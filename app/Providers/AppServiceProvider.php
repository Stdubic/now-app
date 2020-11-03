<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->bindConfigs();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
	}

	private function bindConfigs()
	{
		return config([
			'app.url' => url(''),
			'app.name' => setting('app_name'),
			'mail.host' => setting('smtp_host'),
			'mail.port' => setting('smtp_port'),
			'mail.encryption' => setting('smtp_protocol'),
			'mail.username' => setting('smtp_username'),
			'mail.password' => setting('smtp_password'),
			'mail.from.address' => setting('app_email'),
			'mail.from.name' => setting('app_name'),
			'jwt.secret' => setting('jwt_secret_key'),
			'jwt.ttl' => setting('jwt_expiration_time'),
			'filesystems.disks.s3.key' => setting('aws_access_key_id'),
            'filesystems.disks.s3.secret' => setting('aws_secret_access_key'),
            'filesystems.disks.s3.region' => setting('aws_default_region'),
            'filesystems.disks.s3.bucket' => setting('aws_bucket_name'),
            'filesystems.disks.s3.url' => setting('aws_bucket_url')
		]);
	}
}
