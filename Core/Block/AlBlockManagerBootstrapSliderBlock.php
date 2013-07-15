<?php
/*
 * This file is part of the BootstrapSliderBlockBundle and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright 
 * notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    MIT LICENSE
 * 
 */

namespace AlphaLemon\Block\BootstrapSliderBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\ImagesBlock\AlBlockManagerImages;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBase;

/**
 * Defines the Block Manager to handle a Bootstrap Carousel slider
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapSliderBlock  extends AlBlockManagerImages
{
    /**
     * {@inheritdoc}
     */
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
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function editorParameters()
    {        
        $items = AlBlockManagerJsonBase::decodeJsonContent($this->alBlock->getContent());
        
        $formClass = $this->container->get('bootstrapsliderblock.form');
        $form = $this->container->get('form.factory')->create($formClass);
        
        return array(
            "template" => 'BootstrapSliderBlockBundle:Editor:_editor.html.twig',
            "title" => "Slider editor",
            "form" => $form->createView(),
            'items' => $items,
            'configuration' => $this->container->get('alpha_lemon_cms.configuration'), 
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderHtml()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $images = AlBlockManagerJsonBase::decodeJsonContent($this->alBlock);
        
        return array(
            "RenderView" => array(
                "view" => "BootstrapSliderBlockBundle:Slider:slider.html.twig",
                "options" => array(
                    "items" => $images,
                )
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function edit(array $values)
    {
        $values = $this->removeFormNameReference($values);
        
        return parent::edit($values);
    }
    
    /**
     * Removes the form name from the images' attributes given back from the attributes 
     * form
     *
     * @param array $values
     * @return array
     */
    protected function removeFormNameReference(array $values)
    {
        if (array_key_exists('Content', $values)) {
            $formClass = $this->container->get('bootstrapsliderblock.form');
            $buttonForm = $this->container->get('form.factory')->create($formClass);

            $formName = $buttonForm->getName() . "_";  
            $values["Content"] = str_replace($formName, "", $values["Content"]);
        }
        
        return $values;
    }
}
