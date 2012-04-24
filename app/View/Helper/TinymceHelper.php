<?php
// app/View/Helper/TinymceHelper.php
 
App::uses('AppHelper', 'View/Helper');
 
class TinymceHelper extends AppHelper
{
   
    // Take advantage of other helpers
    public $helpers = array('Js', 'Html', 'Form');
   
    // Check if the tiny_mce.js file has been added or not
    public $_script = false;
   
    /**
     * Adds the tiny_mce.js file and constructs the options
     *
     * @param string $fieldName Name of a field, like this "Modelname.fieldname"
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea
     * @return string JavaScript code to initialise the TinyMCE area
     */
  function _build($fieldName, $tinyoptions = array())
  {
    if(!$this->_script)
    {
      // We don't want to add this every time, it's only needed once
      $this->_script = true;
            $this->Html->script('tiny_mce/tiny_mce', array('inline' => false));
            $this->Html->scriptStart(array('inline'=>false));
                echo "function send_to_editor(content){";
                echo "var ed = tinyMCE.activeEditor;";
                echo "ed.execCommand('mceInsertContent',false,content);"; 
                echo "}";
            $this->Html->scriptEnd();
    }
       
        // Ties the options to the field
        $tinyoptions['mode'] = 'exact';
        $tinyoptions['elements'] = $this->domId($fieldName);
       
        // Liste les keys ayant une fonction
        $value_arr = array();
        $replace_keys = array();
        foreach($tinyoptions as $key => &$value)
        {
            // Verifie si la valeur commence par 'function('
            if(strpos($value, 'function(') === 0)
            {
                $value_arr[] = $value;
                $value = '%' . $key . '%';
                $replace_keys[] = '"' . $value . '"';
            }
        }
       
        // Encode l'array en json
        $json = $this->Js->object($tinyoptions);
       
        // Remplace les fonctions
        $json = str_replace($replace_keys, $value_arr, $json);
       
        $this->Js->buffer('tinyMCE.init(' . $json . ');');
        return $this->Js->writeBuffer();
    }
 
    /**
     * Creates a TinyMCE textarea.
     *
     * @param string $fieldName Name of a field, like this "Modelname.fieldname"
     * @param array $options Array of HTML attributes.
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea
     * @param string $preset
     * @return string An HTML textarea element with TinyMCE
     */
    function textarea($fieldName, $options = array(), $tinyoptions = array(), $preset = null)
    {
        // If a preset is defined
        if(!empty($preset))
        {
            $preset_options = $this->preset($preset);
           
            // If $preset_options && $tinyoptions are an array
            if(is_array($preset_options) && is_array($tinyoptions))
            {
                $tinyoptions = array_merge($preset_options, $tinyoptions);
            }
            else
            {
                $tinyoptions = $preset_options;
            }
        }
       
        return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
    }
 
    /**
     * Creates a TinyMCE textarea.
     *
     * @param string $fieldName Name of a field, like this "Modelname.fieldname"
     * @param array $options Array of HTML attributes.
     * @param array $tinyoptions Array of TinyMCE attributes for this textarea
     * @return string An HTML textarea element with TinyMCE
     */
    function input($fieldName, $options = array(), $tinyoptions = array(), $preset = null)
    {
        // If a preset is defined
        if(!empty($preset))
        {
            $preset_options = $this->preset($preset);
           
            // If $preset_options && $tinyoptions are an array
            if(is_array($preset_options) && is_array($tinyoptions))
            {
                $tinyoptions = array_merge($preset_options, $tinyoptions);
            }
            else
            {
                $tinyoptions = $preset_options;
            }
        }
       
        $options['type'] = 'textarea';
        return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
    }
   
    /**
     * Creates a preset for TinyOptions
     *
     * @param string $name
     * @return array
     */
    private function preset($name)
    {
        // Perso
        if($name == 'perso')
        {
            return array(
                'mode' => 'textareas',
                'theme'=> 'advanced',
                'skin' => "o2k7",
                'skin_variant' => "silver",
                'editor_deselector' => "mceNoEditor",
                'plugins'=> 'save, inlinepopups,paste,table,image, fullscreen, info, latex',
                'entity_encoding' => "raw",
                
                'theme_advanced_buttons1' => 'save,|,bold,italic,underline,|,undo,redo,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,link,unlink,|,image, infobulle, latex,table,|, fullscreen,|, code',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_buttons4' => '',
                'theme_advanced_toolbar_location'=>'top',
                'theme_advanced_toolbar_align' => "left",
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_text_colors' => "FF00FF,FFFF00,000000",
                'width' => '655',
                'height' => '350',
                'paste_remove_styles' => true,
                'paste_remove_spans' => true,
                'paste_stip_class_attributes' => "all",
                'relative_urls' => false,
                'content_css' => '/css/wysiwyg.css'
            );
        }
        
        // Ressource
        if($name == 'ressource')
        {
            return array(
                'mode' => 'textareas',
                'theme'=> 'advanced',
                'skin' => "o2k7",
                'skin_variant' => "silver",
                'editor_deselector' => "mceNoEditor",
                'plugins'=> 'save, inlinepopups,paste,table,image, fullscreen, info, latex, youtube, advlink',
                'entity_encoding' => "raw",
                
                'theme_advanced_buttons1' => 'save,|,bold,italic,underline,|,undo,redo,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,|, infobulle,|,bullist,numlist,|,forecolor, sub, sup,|,link,unlink,|,image, youtube, latex,table,|, code,|, fullscreen',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_buttons4' => '',
                'theme_advanced_toolbar_location'=>'top',
                'theme_advanced_toolbar_align' => "left",
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_text_colors' => "FF00FF,FFFF00,000000",
                'theme_advanced_more_colors' => false,
                'theme_advanced_styles' => "Titre de partie=h2;Titre de sous-partie=h3;",
                'theme_advanced_blockformats' => "h2,h3",
                'theme_advanced_resizing_max_width' => '700',
                'width' => '700',
                'height' => '650',
                'paste_remove_styles' => true,
                'paste_remove_spans' => true,
                'paste_stip_class_attributes' => "all",
                'relative_urls' => false,
                'content_css' => '/css/wysiwyg.css'
            );
        }
        
        // Full Feature
        if($name == 'full')
        {
            return array(
                'theme' => 'advanced',
                'plugins' => 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
                'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
                'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
                'theme_advanced_buttons3' => 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen',
                'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => true,
                'file_browser_callback' => 'ckfinder_for_tiny_mce'
            );
        }
       
        // basic
        if($name == 'basic')
        {
            return array(
                'theme' => 'advanced',
                'plugins' => 'safari,advlink,paste',
                'theme_advanced_buttons1' => 'code,|,copy,pastetext,|,bold,italic,underline,|,link,unlink,|,bullist,numlist',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'center',
                'theme_advanced_statusbar_location' => 'none',
                'theme_advanced_resizing' => false,
                'theme_advanced_resize_horizontal' => false,
                'convert_fonts_to_spans' => false
            );
        }
 
        // simple
        if($name == 'simple')
        {
            return array(
                'theme' => 'simple',
            );
        }
 
        // BBCode
        if($name == 'bbcode')
        {
            return array(
                'theme' => 'advanced',
                'plugins' => 'bbcode',
                'theme_advanced_buttons1' => 'bold,italic,underline,undo,redo,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code',
                'theme_advanced_buttons2' => '',
                'theme_advanced_buttons3' => '',
                'theme_advanced_toolbar_location' => 'top',
                'theme_advanced_toolbar_align' => 'left',
                'theme_advanced_styles' => 'Code=codeStyle;Quote=quoteStyle',
                'theme_advanced_statusbar_location' => 'bottom',
                'theme_advanced_resizing' => true,
                'theme_advanced_resize_horizontal' => false,
                'entity_encoding' => 'raw',
                'add_unload_trigger' => false,
                'remove_linebreaks' => false,
                'inline_styles' => false
            );
        }
       
        return null;
    }
}
?>