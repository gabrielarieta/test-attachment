<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if ( ! function_exists( 'debug' ) ) {

    /**
     * Registra uma mensagem de debug no console
     *
     * @param $message
     */
    function debug( $message )
    {
        print $message . PHP_EOL;
    }

}

if ( ! function_exists( 'getNewModel' ) ) {

    /**
     * Retorna uma nova model
     *
     * @param $modelName
     * @param $source
     * @return mixed
     */
    function getNewModel( $modelName, $source = null )
    {

        $className = str_replace( 'Repository', '', $modelName );

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( app_path() . "/Models")
        );

        $classes = new RegexIterator( $files, '/\.php$/' );
        $namespaces = [];

        foreach ( $classes as $class ) {

            $content = file_get_contents( $class->getRealPath() );
            $tokens  = token_get_all( $content );

            $namespace = null;

            for ( $index = 0; isset( $tokens[$index]) ; $index++ ) {

                if ( ! isset( $tokens[$index][0] ) ) {
                    continue;
                }

                if ( T_NAMESPACE === $tokens[$index][0] ) {

                    $index += 2;

                    while ( isset( $tokens[$index] ) && is_array( $tokens[$index] ) ) {
                        $namespace .= $tokens[$index++][1];
                    }

                    if ( ! Str::contains( $namespace, "Auth" ) )
                        $namespaces[] = $namespace;

                }

            }

        }

        foreach ( array_unique( $namespaces ) as $namespace ) {

            $class = "$namespace\\$className";

            if ( class_exists( $class ) )
                return new $class();

        }

        return false;

    }

}
