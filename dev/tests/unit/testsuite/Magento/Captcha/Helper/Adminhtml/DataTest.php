<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Captcha\Helper\Adminhtml;

class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Captcha\Helper\Adminhtml\Data | |PHPUnit_Framework_MockObject_MockObject
     */
    protected $_model;

    /**
     * setUp
     */
    protected function setUp()
    {
        $objectManagerHelper = new \Magento\TestFramework\Helper\ObjectManager($this);
        $className = 'Magento\Captcha\Helper\Adminhtml\Data';
        $arguments = $objectManagerHelper->getConstructArguments($className);

        $backendConfig = $arguments['backendConfig'];
        $backendConfig->expects(
            $this->any()
        )->method(
            'getValue'
        )->with(
            'admin/captcha/qwe'
        )->will(
            $this->returnValue('1')
        );

        $filesystemMock = $arguments['filesystem'];
        $directoryMock = $this->getMock('Magento\Framework\Filesystem\Directory\Write', [], [], '', false);

        $filesystemMock->expects($this->any())->method('getDirectoryWrite')->will($this->returnValue($directoryMock));
        $directoryMock->expects($this->any())->method('getAbsolutePath')->will($this->returnArgument(0));

        $this->_model = $objectManagerHelper->getObject($className, $arguments);
    }

    public function testGetConfig()
    {
        $this->assertEquals('1', $this->_model->getConfig('qwe'));
    }

    /**
     * @covers \Magento\Captcha\Helper\Adminhtml\Data::_getWebsiteCode
     */
    public function testGetWebsiteId()
    {
        $this->assertStringEndsWith('/admin/', $this->_model->getImgDir());
    }
}
