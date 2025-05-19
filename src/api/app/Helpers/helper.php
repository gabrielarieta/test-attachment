<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if ( ! function_exists( 'nameFormat' ) ) {

    /**
     * Retorna um nome formatado
     *
     * @param $name
     * @param array $exclude
     * @return array|string
     */
    function nameFormat( $name, $exclude = [] )
    {

        if ( is_array( $name ) ) {

            $fn = function ( &$value, $key ) use ($exclude) {
                $value = !in_array( $key, $exclude ) ? nameFormat( $value ) : $value;
            };

            array_walk( $name, $fn );

            return $name;

        } else {

            $arr = [
                'da'   => 'da',
                'das'  => 'das',
                'de'   => 'de',
                'di'   => 'di',
                'do'   => 'do',
                'dos'  => 'dos',
                'e'    => 'e',
                'el'   => 'el',
                'i'    => 'I',
                'ii'   => 'II',
                'iii'  => 'III',
                'iv'   => 'IV',
                'v'    => 'V',
                'vi'   => 'VI',
                'vii'  => 'VII',
                'viii' => 'VIII',
                'ix'   => 'IX',
                'x'    => 'X',
                'xi'   => 'XI',
                'xii'  => 'XII',
                'xiii' => 'XIII'
            ];

            $fn = function ( $word ) use ( $arr ) {
                return ( ! array_key_exists( $word, $arr ) ) ? mb_convert_case( trim( $word ), MB_CASE_TITLE, 'utf-8' ) : $arr[$word];
            };

            return join( ' ', array_map( $fn, explode( ' ', mb_strtolower( trim( $name ), 'utf-8' ) ) ) );

        }

    }

}

if ( ! function_exists( 'camelToKebab' ) ) {

    /**
     * Transforma uma string de CamelCase para kebab-case
     *
     * @param $string
     * @return string
     */
    function camelToKebab( $string )
    {

        $divisor = strcspn( $string, 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ' );

        $array = str_split( $string, $divisor );

        return implode(
            '-',
            array_map( 'strtolower', $array )
        );

    }

}

if ( ! function_exists( 'kebabToCamel' ) ) {

    /**
     * Transforma uma string de kebab-case para CamelCase
     *
     * @param $string
     * @return string
     */
    function kebabToCamel( $string )
    {

        return lcfirst(
            implode( '', array_map(
                    'ucfirst',
                    explode( '-', $string )
                )
            )
        );

    }

}

if ( ! function_exists( 'prepare' ) ) {

    /**
     * Prepara os dados para serem salvos no banco de dados
     *
     * @param $data
     * @param $column
     * @return array
     */
    function prepare( $data, $column )
    {

        $data->$column = $data->id;

        unset( $data->id );

        return collect( $data )->toArray();

    }

}

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

if ( ! function_exists( 'preventCache' ) ) {

    /**
     * Previne que um arquivo CSS ou JS seja carregado do cache aplicando um parametro de versÃ£o
     *
     * @return string|null
     */
    function preventCache()
    {
        return config( 'app.env' ) === 'local' ? '?v=' . time() : null;
    }

}

if ( ! function_exists( 'isCurrentRoute' ) ) {

    /**
     * Verifica se o menu corresponde a rota atual
     *
     * @param $route_name
     * @return string
     */
    function isCurrentRoute($route_name)
    {

        if ( ! is_array( $route_name ) ) {

            return Route::is( $route_name ) ? 'active' : '';

        } else {

            return in_array( Route::currentRouteName(), $route_name ) ? 'active' : '';

        }

    }

}

if ( ! function_exists( 'errorMessageFormat' ) ) {

    /**
     * Formata a mensagem de erro deixando o nome do campo em negrito
     *
     * @param $error
     * @return mixed
     */
    function errorMessageFormat($error)
    {

        if ( Str::contains( $error, ':' ) ) {

            $attribute = Str::before( Str::after( $error, ":" ), ' ' );

            $error = str_replace(':', '', str_replace($attribute, '<b>' . $attribute . '</b>', $error));

            $error = str_replace('_', ' ', $error);

        }

        return $error;
    }

}

if ( ! function_exists( 'logRequestBody' ) ) {

    /**
     * Registra o log de um objeto JSON
     *
     * @param $title
     * @param $data
     */
    function logJson( $title, $data ) {

        \Illuminate\Support\Facades\Log::info(
            strtoupper( $title ) . ":: " . json_encode( $data )
        );

    }

}

if ( ! function_exists( 'resolveCpf' ) ) {

    /**
     * Retorna o numero do CPF adicionando os zeros a esquerda que foram omitidos
     *
     * @param $numCpf
     * @return string
     */
    function resolveCpf( $numCpf )
    {

        return str_repeat( "0", ( 11 - strlen( $numCpf ) ) ) . $numCpf;
    }

}

if ( ! function_exists( 'loadRepositories' ) ) {

    /**
     * Carrega todos os repositórios
     *
     * @return stdClass
     */
    function loadRepositories()
    {

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( app_path() . "/Repositories" )
        );

        $classes = new RegexIterator( $files, '/\.php$/' );

        $repositories = new stdClass();

        foreach ( $classes as $class ) {

            $prefix = \Illuminate\Support\Str::camel(
                preg_replace( '(Repository|.php)', '', $class->getFilename() )
            );

            if ( $prefix !== 'base' ) {

                $className = '\\App\Repositories\\' . str_replace( '.php', '', $class->getFilename() );

                $repositories->$prefix = new $className();

            }

        }

        return $repositories;
    }

}

if ( ! function_exists( 'color' ) ) {

    /**
     * Retorna a cor de acordo com a chave
     *
     * @param string $key
     * @return mixed
     */
    function color( string $key )
    {

        $colors = [
            'danger'  => 'red',
            'warning' => 'orange',
            'success' => 'teal'
        ];

        return $colors[ $key ];
    }

}

if ( ! function_exists( 'divide' ) ) {

    /**
     * Realiza uma operação de divisão
     *
     * @param $value1
     * @param $value2
     * @return float|int
     */
    function divide( $value1, $value2 )
    {

        if ( $value2 == 0 ) {

            return 0;
        }

        return $value1 / $value2;
    }

}

if ( ! function_exists( 'phoneFormat' ) ) {

    /**
     * Retorna o telefone celular formatado
     *
     * @param $ddd
     * @param $phone
     * @return string|null
     */

    function phoneFormat ( $ddd, $phone )
    {

        $dddFormated = strripos( $ddd, '0' ) === 0 ? substr( $ddd, 1) : $ddd;

        $phoneFormated = str_replace( ['-','.',' '],'',$phone );

        $result = trim( $dddFormated . $phoneFormated );

        if ( ! empty( $result  ) ) {

            return '+55' . $result;
        }

        return null;

    }

}

if ( ! function_exists( 'hospital' ) ) {

    /**
     * Retorna o hospital
     *
     * @param $string
     * @return mixed|null
     */

    function hospital ( $string )
    {

        $sigla = null;

        $hospital = [
            'HSJ' => 'HOSPITAL SÃO JOSÉ',
            'HSR' => 'HOSPITAL SANTA RITA',
            'HCSA' => 'HOSPITAL DA CRIANÇA SANTO ANTÔNIO',
            'HDVS' => 'HOSPITAL DOM VICENTE SCHERER',
            'HSC' => 'HOSPITAL SANTA CLARA',
            'HSF' => 'HOSPITAL SÃO FRANCISCO',
            'PPF' => 'PAVILHÃO PEREIRA FILHO',
            'HDJB' => 'HOSPITAL DOM JOÃO BECKER',
            'HSAP' => 'HOSPITAL DE SANTO ANTÔNIO DA PATRULHA',
            'MULTICENTROS' => 'MULTICENTROS',
        ];

        if ( ! is_null( $string ) )
            $sigla = explode( ' ', $string, 2 )[0];

        if ( ! array_key_exists( $sigla, $hospital ) )
            return null;

        return $hospital[ $sigla ];

    }
}

if ( ! function_exists( 'dateFormat' ) ) {

    /**
     * Retorna uma data no formato especificado
     *
     * @param $value
     * @param string $format
     * @return string
     * @throws Exception
     */
    function dateFormat( $value, $format = 'd/m/Y' ){

        if( !is_null( $value ) ) {

            if ( $format === 'Y-m-d' ) {
                $value = \Illuminate\Support\Carbon::createFromFormat( 'd/m/Y', $value );
            }

            return ( new \Illuminate\Support\Carbon( $value ) )->format( $format );

        }
    }
}

if ( ! function_exists( 'formatMessage' ) ) {

    function formatMessage ( $message ) {

        $text = null;

        if ( ! is_null( $message ) ) {

            preg_match( '#<m.*?>(.*?)</m>#i', $message, $m );

            $text = $m[1];
        }

        return $text;
    }

}

if ( ! function_exists( 'formatClientName' ) ) {

    function formatClientName( $name )
    {

        return strtoupper(str_replace(' ','_',$name));
    }

}
