<?php

/**
 * Our list of bars.
 * 
 * controllers/bars.php
 *
 * ------------------------------------------------------------------------
 */
class Bars extends Application {

    function __construct() {
        parent::__construct();
        $this->load->model('barsmodel');
        $this->activeuser->restrict(array(ROLE_ADMIN, ROLE_USER));
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    
    function index() {

        $this->data['title'] = "Bars in Greater Vancouver";
        $this->data['page'] = 'Bars';
        $this->data['title'] = 'Greater Vancouver Pub Reviews';
        $this->data['pageTitle'] = 'Bars in the Lower Mainland';
        $this->data['pageDescrip'] = 'Lorem ipsum dolor amet sit consectetur adipiscing';
        $this->data['pagebody'] = 'bars/bars';
        $this->data['report_heading'] = $this->build_report_header();
        $this->data['report_body'] = $this->build_report_body();
        
        $this->render();
    }

    function build_report_header(){
        $result = '';
        // parse(view, params, true to return string)
        $result .= $this->parser->parse('bars/bar_headings', $this->data, true);
        return $result;
    }
    
    function build_report_body(){
        $result = '';
        // iterate over the cities
        // before row
        // for each city, iterate over the bars
        // after row
        
        $cities = $this->barsmodel->getCities();
        foreach($cities as $city){
            // Before row
            $view_params['city_name'] = $city;
            $result .= $this->parser->parse('bars/bars_city_before', $view_params, true);
            $count = 0;
            
            // bars
            $bars = $this->barsmodel->getBarsInCity($city);
            foreach($bars as $bar){
                
                $view_params['bar_name'] = $bar['NAME'];
                $view_params['bar_address'] = $bar['ADDRESS'];
                $view_params['bar_capacity'] = $bar['CAPACITY'];
                $result .= $this->parser->parse('bars/bars_row', $view_params, true);
                
                $count++;
            }
            
            // after row
            $view_params['city_name'] = $city;
            $view_params['count'] = $count;
            $result .= $this->parser->parse('bars/bars_city_after', $view_params, true);
        }
        
        $result .= '';
        
        return $result;
    }
}

/* End of file bars.php */
/* Location: application/controllers/bars.php */