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
 
namespace AlphaLemon\Block\BootstrapSliderBlockBundle\Tests\Unit\Core\Form;

use AlphaLemon\AlphaLemonCmsBundle\Tests\Unit\Core\Form\Base\AlBaseType;
use AlphaLemon\Block\BootstrapSliderBlockBundle\Core\Form\AlSliderType;

/**
 * AlSliderTypeTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlSliderTypeTest extends AlBaseType
{
    protected function configureFields()
    {
        return array(
            'src',
            'data_src',
            'title',
            'alt',
            'caption_title',
            'caption_body',
        );
    }
    
    protected function getForm()
    {
        return new AlSliderType();
    }
    
    public function testDefaultOptions()
    {
        $this->assertEquals(array('csrf_protection' =>false), $this->getForm()->getDefaultOptions(array()));
    }
    
    public function testGetName()
    {
        $this->assertEquals('al_json_block', $this->getForm()->getName());
    }
}
