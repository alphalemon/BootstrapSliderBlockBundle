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
 
namespace AlphaLemon\Block\BootstrapSliderBlockBundle\Tests\Unit\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Tests\Unit\Core\Content\Block\Base\AlBlockManagerContainerBase;
use AlphaLemon\Block\BootstrapSliderBlockBundle\Core\Block\AlBlockManagerBootstrapSliderBlock;

class AlBlockManagerBootstrapSliderBlockTester extends AlBlockManagerBootstrapSliderBlock
{
    public function removeFormNameReferenceTester($values)
    {
        return $this->removeFormNameReference($values);
    }
}

/**
 * AlBlockManagerBootstrapSliderBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapSliderBlockTest extends AlBlockManagerContainerBase
{  
    public function testDefaultValue()
    {
        $expectedValue = array(
            "Content" =>    
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
        }',
        'InternalJavascript' => '$(".carousel").carousel("pause");',
        );
            
        $this->initContainer(); 
        $blockManager = new AlBlockManagerBootstrapSliderBlock($this->container, $this->validator);
        $this->assertEquals($expectedValue, $blockManager->getDefaultValue());
    }
    
    public function testGetHtmlReturnsAnEmptyStringWhenAnyBlockIsDefined()
    {
        $this->initContainer();
        $blockManager = new AlBlockManagerBootstrapSliderBlock($this->container, $this->validator);
                
        $this->assertEquals("", $blockManager->getHtml());
    }
    
    public function testGetHtml()
    {
        $value = '{
            "0" : {
                "src": "/path/to/image",
                "data_src" : "holder.js/400x280",
                "title" : "Sample title",
                "alt" : "Sample alt",
                "caption_title" : "First Thumbnail label",
                "caption_body" : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
            }
        }';
        
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $blockManager = new AlBlockManagerBootstrapSliderBlock($this->container, $this->validator);
        $blockManager->set($block);
        
        $expectedResult = array('RenderView' => array(
            'view' => 'BootstrapSliderBlockBundle:Slider:slider.html.twig',
            'options' => array(
                'items' => array(
                    array(
                        "src" => "/path/to/image",
                        "data_src" => "holder.js/400x280",
                        "title" => "Sample title",
                        "alt" => "Sample alt",
                        "caption_title" => "First Thumbnail label",
                        "caption_body" => "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.",
                    ),
                ),
                'block_manager' => $blockManager,
            ),
        ));
        
        $this->assertEquals($expectedResult, $blockManager->getHtml());
    }
    
    public function testEditorParameters()
    {
        $value = '{
            "0" : {
                "src": "/path/to/image",
                "data_src" : "holder.js/400x280",
                "title" : "Sample title",
                "alt" : "Sample alt",
                "caption_title" : "First Thumbnail label",
                "caption_body" : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
            }
        }';
        
        $block = $this->initBlock($value);
        $this->initContainer();
        $form = $this->initFormFactory();        
        $form->expects($this->once())
            ->method('createView')
        ;
        
        $blockManager = new AlBlockManagerBootstrapSliderBlock($this->container, $this->validator);
        $blockManager->set($block);
        $result = $blockManager->editorParameters();
        $this->assertEquals('BootstrapSliderBlockBundle:Editor:_editor.html.twig', $result["template"]);
    }
    
    public function testRemoveFormNameReference()
    {
        $this->initContainer();
        $form = $this->initFormFactory();
        $form->expects($this->once())
              ->method('getName')
              ->will($this->returnValue('al_json_block'))
        ;
        
        $values = array(
            "Content" => '[{"al_json_block_src":"","al_json_block_title":"Sample title 112","al_json_block_alt":"Sample alt","al_json_block_caption_title":"First Thumbnail label","al_json_block_caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.","al_json_block_data_src":"holder.js/400x280"},{"al_json_block_src":"","al_json_block_data_src":"holder.js/400x280","al_json_block_title":"Sample title","al_json_block_alt":"Sample alt","al_json_block_caption_title":"Second Thumbnail label","al_json_block_caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."},{"al_json_block_src":"","al_json_block_data_src":"holder.js/400x280","al_json_block_title":"Sample title","al_json_block_alt":"Sample alt","al_json_block_caption_title":"Third Thumbnail label","al_json_block_caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."}]',            
        );
        
        $expectedResult = array(
            "Content" => '[{"src":"","title":"Sample title 112","alt":"Sample alt","caption_title":"First Thumbnail label","caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.","data_src":"holder.js/400x280"},{"src":"","data_src":"holder.js/400x280","title":"Sample title","alt":"Sample alt","caption_title":"Second Thumbnail label","caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."},{"src":"","data_src":"holder.js/400x280","title":"Sample title","alt":"Sample alt","caption_title":"Third Thumbnail label","caption_body":"Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."}]',
        );
        
        $blockManager = new AlBlockManagerBootstrapSliderBlockTester($this->container, $this->validator);
        $this->assertEquals($expectedResult, $blockManager->removeFormNameReferenceTester($values));
    }
    
    protected function initBlock($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
              ->method('getContent')
              ->will($this->returnValue($value));

        return $block;
    }
    
    protected function initForm()
    {
        return $this->getMockBuilder('Symfony\Component\Form\Form')
                    ->disableOriginalConstructor()
                    ->getMock();
    }
    
    private function initFormFactory()
    {
        $form = $this->initForm();
        $formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $formFactory->expects($this->at(0))
                    ->method('create')
                    ->will($this->returnValue($form))
        ;
        
        $formType = $this->getMock('Symfony\Component\Form\FormTypeInterface');
        $this->container->expects($this->at(2))
                        ->method('get')
                        ->with('bootstrapsliderblock.form')
                        ->will($this->returnValue($formType))
        ;
        
        $this->container->expects($this->at(3))
                        ->method('get')
                        ->with('form.factory')
                        ->will($this->returnValue($formFactory))
        ;
        
        return $form;
    }
}
