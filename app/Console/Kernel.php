<?php

namespace Tamkeen\Ajeer\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Tamkeen\Ajeer\Console\Commands\SendNotifyEmail;
use Tamkeen\Ajeer\Console\Commands\SendNotifyEmailForRating;
use Tamkeen\Ajeer\Console\Commands\SendNotifyEmailPeriodic;
use Tamkeen\Ajeer\Models\TaqyeemTemplatePermission;
use Tamkeen\Ajeer\Http\Controllers\Admin\ContractMembersTaqyeemController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
	    SendNotifyEmail::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
	    $this->schedulePeriodic( $schedule );
	    $this->scheduleDate( $schedule );

            $schedule->call(function () {
                ContractMembersTaqyeemController::sendToMembers();
            })->daily();
    }

	/**
	 * @param Schedule $schedule
	 */
	protected function schedulePeriodic( Schedule $schedule ) {
		$schedule->command( 'dream:send_taqyeem' )
		         ->monthly()
		         ->when( function () {
			         $permissions = TaqyeemTemplatePermission::all();
			         foreach ( $permissions as $permission ) {
				         if ( $permission->periodic_or_date == 1 && $permission->periodic_period == 1 ) {
					         return true;
				         }
			         }
		         } );

		$schedule->command( 'dream:send_taqyeem' )
		         ->cron( '0 0 1 */3 *' )
		         ->when( function () {
			         $permissions = TaqyeemTemplatePermission::all();
			         foreach ( $permissions as $permission ) {
				         if ( $permission->periodic_or_date == 1 && $permission->periodic_period == 3 ) {
					         return true;
				         }
			         }
		         } );

		$schedule->command( 'dream:send_taqyeem' )
		         ->cron( '0 0 1 6 * *' )
		         ->when( function () {
			         $permissions = TaqyeemTemplatePermission::all();
			         foreach ( $permissions as $permission ) {
				         if ( $permission->periodic_or_date == 1 && $permission->periodic_period == 6 ) {
					         return true;
				         }
			         }
		         } );

		$schedule->command( 'dream:send_taqyeem' )
		         ->yearly()
		         ->when( function () {
			         $permissions = TaqyeemTemplatePermission::all();
			         foreach ( $permissions as $permission ) {
				         if ( $permission->periodic_or_date == 1 && $permission->periodic_period == 12 ) {
					         return true;
				         }
			         }
		         } );
	}

	/**
	 * @param Schedule $schedule
	 */
	protected function scheduleDate( Schedule $schedule ) {
		$schedule->command( 'dream:send_taqyeem' )
		         ->daily()
		         ->when( function () {
			         $permissions = TaqyeemTemplatePermission::all();
			         foreach ( $permissions as $permission ) {
				         if ( $permission->periodic_or_date == 2 && $permission->taqyeem_date == Carbon::today()->toDateString() ) {
					         return true;
				         }
			         }
		         } );
	}
}