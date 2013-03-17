<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapSliderBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\ImagesBlock\AlBlockManagerImages;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

/**
 * Description of AlBlockManagerBootstrapSliderBlock
 */
class AlBlockManagerBootstrapSliderBlock  extends AlBlockManagerImages
{
    public function getDefaultValue()
    {
        $defaultValue =
        '{
            "0" : {
                "src": "",
                "data_src" : "holder.js/400x280",
                "title" : "Sample title",
                "alt" : "Sample alt",
                "caption_title" : "First Thumbnail label",
                "caption_body" : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
            },
            "1" : {
                "src": "",
                "data_src" : "holder.js/400x280",
                "title" : "Sample title",
                "alt" : "Sample alt",
                "caption_title" : "Second Thumbnail label",
                "caption_body" : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
            },
            "2" : {
                "src": "",
                "data_src" : "holder.js/400x280",
                "title" : "Sample title",
                "alt" : "Sample alt",
                "caption_title" : "Third Thumbnail label",
                "caption_body" : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
            }
        }';

        return array(
            'Content' => $defaultValue,
            'InternalJavascript' => '$(".carousel").carousel("pause");'
        );
    }
    
    public function isColumnVisible()
    {
        return null;
    }
    
    public function getHtml()
    {
        if (null === $this->alBlock) return "";
        
        $images = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
        
        return array(
            "RenderView" => array(
                "view" => "BootstrapSliderBlockBundle:Slider:slider.html.twig",
                "options" => array(
                    "items" => $images,
                )
            )
        );
    }
    
    public function getContentForEditor()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $images = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
        
        return array_map(function($el)
            { 
                $image = str_replace("\\", "/", $el['image']);
                
                return array_merge($el, array('id' => md5($image), 'image' => $image));             
            }, $images
        );
    }
    
    protected function replaceHtmlCmsActive()
    {
        $buttons = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        $formClass = $this->container->get('bootstrapsliderblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass);
        
        return array('RenderView' => array(
            'view' => 'BootstrapSliderBlockBundle:Editor:bootstrapsliderblock_editor.html.twig',
            'options' => array(
                'items' => $buttons, 
                'block_manager' => $this,
                'form' => $buttonForm->createView(), 
                'parent' => $this->alBlock,
            ),
        ));
    }
    
    protected function edit(array $values)
    {
        $formClass = $this->container->get('bootstrapsliderblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass);
        
        $formName = $buttonForm->getName() . "_";
        $values["Content"] = str_replace($formName, "", $values["Content"]);
        
        return parent::edit($values);
    }
}
