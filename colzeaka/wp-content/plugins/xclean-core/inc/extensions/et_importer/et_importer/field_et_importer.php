<?php

if ( !defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'ReduxFramework_et_importer' ) ) {


    class ReduxFramework_et_importer {


        function __construct( $field = array(), $value ='', $parent ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }

            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );
        }

        public function render() {

            $demo_data = get_option('et_demo_importer');

            echo '<div class="et-import-section">';

            if ( ! isset( $demo_data ) || empty( $demo_data ) || $demo_data == false ) {
                echo '<p class="et-pre-install">Click to install demo content</p>';
                echo '<button id="et-install-demo">Install Demo</button>';
            } else {
                echo '<div id="et-installed-success">Demo data already installed</div>';
            }

            echo '</div>';

        }

        public function enqueue() {

            $min = Redux_Functions::isMin();

            wp_enqueue_script(
                'redux-field-wbc-importer-js',

                $this->extension_url . '/field_et_importer.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-et-importer-css',
                $this->extension_url . 'field_et_importer.css',
                time(),
                true
            );

        }

    }
}

















