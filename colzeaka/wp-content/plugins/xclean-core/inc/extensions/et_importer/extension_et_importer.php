<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;
// Don't duplicate me!
if( !class_exists( 'ReduxFramework_Extension_et_importer' ) ) {
    /**
     * Main ReduxFramework et_importer extension class
     *
     * @since       3.1.6
     */
    class ReduxFramework_Extension_et_importer {


        public static $theInstance;
        protected $parent;
        public $extension_url;
        public $extension_dir;
    

        public function __construct( $parent ) {
            
            $this->parent = $parent;
            

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
            }

            $this->field_name = 'et_importer';
            
            self::$theInstance = $this;
            
            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this, 'overload_field_path' ) );

            $this->et_import_section();
        }      

        public static function get_instance() {
            return self::$theInstance;
        }

        // Forces the use of the embeded field path vs what the core typically would use    
        public function overload_field_path($field) {
            return dirname(__FILE__).'/'.$this->field_name.'/field_'.$this->field_name.'.php';
        }

        function et_import_section() {

            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'et_importer_section' ) {
                    return;
                }
            }
            // Checks to see if section was set in config of redux.

            $this->parent->sections[] = array(
                'id'     => 'et_importer_section',
                'title'  => __( 'Demo content', 'xclean-core' ),
                'icon'   => 'el-icon-inbox',
                'fields' => array(
                    array(
                        'id'   => 'et_demo_importer',
                        'type' => 'et_importer',
                    )
                )
            );
        }

    } // class
} // if