<?php

namespace Openpay\Banks\Mail\Template;

use Zend\Mime\Mime;
use Zend\Mime\PartFactory;
use Zend\Mail\MessageFactory as MailMessageFactory;
use Zend\Mime\MessageFactory as MimeMessageFactory;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder {
    
    /**
     * @var \Zend\Mime\PartFactory
     */
    protected $partFactory;

    /**
     * @var \Zend\Mime\MessageFactory
     */
    protected $mimeMessageFactory;

    /**
     * @var \Zend\Mail\Message
     */
    private $zendMessage;

    /**
     * @var \Zend\Mime\Part[]
     */
    protected $parts = [];


    /**
     * 
     * @param PartFactory $partFactory
     * @param MimeMessageFactory $mimeMessageFactory
     * @param type $charset
     */
    public function __construct(PartFactory $partFactory, MimeMessageFactory $mimeMessageFactory, $charset = 'utf-8') {
        $this->partFactory = $partFactory;
        $this->mimeMessageFactory = $mimeMessageFactory;
        $this->zendMessage = MailMessageFactory::getInstance();
        $this->zendMessage->setEncoding($charset);
    }
                  

    /**
     * Add an attachment to the message.
     *
     * @param string $content
     * @param string $fileName
     * @param string $fileType
     * @return $this
     */
//    public function addAttachment($content, $fileName, $fileType) {
//        $this->message->setBodyAttachment($content, $fileName, $fileType);
//        return $this;
//    }
    
    /**
     * Add an attachment to the message.
     * 
     * @param type $content
     * @param type $fileName
     * @param type $fileType
     * @return $this
     */
    public function addAttachment($content, $fileName, $fileType) {        
        $attachmentPart = $this->partFactory->create();
        $attachmentPart->setContent($content)
                ->setType($fileType)
                ->setFileName($fileName)
                ->setEncoding(Mime::ENCODING_BASE64)
                ->setDisposition(Mime::DISPOSITION_ATTACHMENT);
        $this->parts[] = $attachmentPart;
        return $this;        
    }

    /**
     * After all parts are set, add them to message body.
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function prepareMessage() {
        parent::prepareMessage();
                
        $mimeMessage = $this->mimeMessageFactory->create();
        $mimeMessage->setParts($this->parts);
        $this->zendMessage->setBody($mimeMessage);        
        
        return $this;
    }

}
