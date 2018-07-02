<?php

namespace Console;

use Freemius_Api;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;

class DownloadCommand extends SymfonyCommand {
	public function configure() {
		$this->setName( 'download' )
		     ->setDescription( 'Download a zip file from Freemius.' )
		     ->setHelp( 'This command line help you to download a zip file as free and/or pro generated version.' )
		     ->addOption( 'plugin-id', null, InputOption::VALUE_REQUIRED, 'The plugin id, is easy to find in the url.' )
		     ->addOption( 'dev-id', null, InputOption::VALUE_REQUIRED, 'The Developer Id, inside product\'s credentials in SETTINGS -> Keys.' )
		     ->addOption( 'public-key', null, InputOption::VALUE_REQUIRED, 'The Public Key, inside product\'s credentials in SETTINGS -> Keys.' )
		     ->addOption( 'secret-key', null, InputOption::VALUE_REQUIRED, 'The Secret Key, inside product\'s credentials in SETTINGS -> Keys.' )
		     ->addOption( 'is-premium', null, InputOption::VALUE_OPTIONAL, 'Determine if the version to download is the Pro or Free generated zip file. Default is TRUE' )
		     ->addOption( 'env', null, InputOption::VALUE_OPTIONAL, 'Determine if load the dev-id, public-key and secret-key from environment. Default FALSE. The expected environment variables are FS__API_DEV_ID, FS__API_PUBLIC_KEY and FS__API_SECRET_KEY.' )
		     ->addArgument( 'path', InputArgument::REQUIRED, 'The destination path where the zip will be generated.' );
	}

	public function execute( InputInterface $input, OutputInterface $output ) {
		$required_options = array( 'plugin-id', 'dev-id', 'public-key', 'secret-key' );
		$options          = $input->getOptions();
		$path             = $input->getArgument( 'path' );
		if ( ! empty( $options['env'] ) ) {
			if ( ! empty( $_ENV['FS__API_DEV_ID'] ) ) {
				$options['dev-id'] = $_ENV['FS__API_DEV_ID'];
			} else {
				return $output->writeln( "<error>The 'FS__API_DEV_ID' environment variable is not valid.</error>" );
			}
			if ( ! empty( $_ENV['FS__API_DEV_ID'] ) ) {
				$options['public-key'] = $_ENV['FS__API_PUBLIC_KEY'];
			} else {
				return $output->writeln( "<error>The 'FS__API_PUBLIC_KEY' environment variable is not valid.</error>" );
			}
			if ( ! empty( $_ENV['FS__API_DEV_ID'] ) ) {
				$options['secret-key'] = $_ENV['FS__API_SECRET_KEY'];
			} else {
				return $output->writeln( "<error>The 'FS__API_SECRET_KEY' environment variable is not valid.</error>" );
			}
		}
		foreach ( $required_options as $required ) {
			if ( empty( $options[ $required ] ) ) {
				return $output->writeln( "<error>The '{$required}' option is REQUIRED! Please provide it.</error>" );
			}
		}

		if ( empty( $path ) ) {
			return $output->writeln( "<error>The 'path' argument is REQUIRED! Please provide it.</error>" );
		}
		if ( file_exists( $path ) ) {
			return $output->writeln( "<error>The path for download the zip '{$path}' is taken, please provide other.</error>" );
		}

		$api = new Freemius_Api( FS__API_SCOPE, intval( $options['dev-id'] ), $options['public-key'], $options['secret-key'] );

		$parameters               = array();
		$parameters['is_premium'] = ( ! empty( $options['contributor'] ) );
		$fileParameter            = array();
		$fileParameter['file']    = $path;
		$is_premium               = ( empty( $options['is-premium'] ) ) ? '' : '?is_premium=false';
		$url                      = '/plugins/' . $options['plugin-id'] . '/updates/latest.zip' . $is_premium;
		$download_url             = $api->GetSignedUrl( $url );
		$path                     = realpath( $path );
		$new_file_content         = file_get_contents( $download_url );
		$file                     = fopen( $path, 'w+' );
		if ( $file !== false ) {
			fwrite( $file, $new_file_content );
			fclose( $file );

			return $output->writeln( "<info>Check your file at '{$path}'</info>" );
		}

		return $output->writeln( "<error>Upss, something was wrong.</error>" );
	}
}
