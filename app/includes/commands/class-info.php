<?php

namespace Dekode\InsightlyCli\Commands;

class Info extends Command {

	/**
	 * Returns the string used to run this command.
	 *
	 * @return string
	 */
	public function get_key(): string {
		return 'info';
	}

	/**
	 * Returns a short description for this command-
	 *
	 * @return string
	 */
	public function get_description(): string {
		return 'Get information about a project.';
	}

	/**
	 * Returns the help text for this command.
	 *
	 * @return string
	 */
	public function get_help(): string {
		$help = "Usage:\nisc find <name of project>\n\n";
		$help .= "Examples:\n";
		$help .= 'isc find finansforbundet.no' . "\n";

		return $help;

	}

	/**
	 * Executes this command
	 */
	public function run() {
		$climate = $this->get_climate();

		if ( ! isset( $this->get_arguments()[2] ) ) {
			$climate->error( 'No project specified.' );
			exit;
		}

		$project = $this->get_most_similar_project_or_die( $this->get_arguments()[2] );

		$climate->green()->bold()->out( '-= ' . strtoupper( $project->get_name() ) . " =- \n" );
		$climate->cyan( "ID:\t\t\t" . $project->get_id() );
		$climate->cyan( "URL:\t\t\t" . $project->get_insightly_url() . "\n" );

		$climate->yellow( "Responsbile advisor:\t" . $project->get_responsible_advisor() );
		$climate->yellow( "Project manager:\t" . $project->get_project_manager() );
		$climate->yellow( "Project team:\t\t" . $project->get_project_team() );
		$climate->yellow( "Service agreement:\t" . $project->get_service_agreement() );
		$climate->yellow( "Hosting agreement:\t" . $project->get_hosting_level_agreement() );
		$climate->yellow( "Incidents report to:\t" . $project->get_incidents_email_report_client() . "\n" );

		$climate->green( "SSH to prod:\t\t" . $project->get_ssh_to_prod() );
		$climate->green( "Web root:\t\t" . $project->get_web_root() );
		$climate->green( "Prod. server:\t\t" . $project->get_prod_server() );
		$climate->green( "Reverse proxy:\t\t" . $project->get_reverse_proxy() );
		$climate->green( "DB instance:\t\t" . $project->get_db_instance() . "\n" );


		$climate->red( "Prod URLs:\t\t" . join( ', ', $project->get_prod_urls() ) );
		$climate->red( "Stage URL:\t\t" . join( ', ', $project->get_stage_urls() ) );

		echo "\n";

		if ( $project->get_hosting_notes() ) {
			$climate->white( 'Hosting notes:' );
			$climate->white( $project->get_hosting_notes() );
		}

	}
}