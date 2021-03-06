<?php

/**
 * This file is part of the MailchimpApiConnector package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace MailchimpApiConnector;

/**
 * Class MailchimpExportApi
 * @package MailchimpApiConnector
 * @description Class to use the Mailchimp Export API <http://apidocs.mailchimp.com/export/>
 * @author Daniel Gomes <me@danielcsgomes.com>
 */
class MailchimpExportApi extends AbstractMailchimpApi implements MailchimpApiInterface
{
    const API_URL = 'http://%s.api.mailchimp.com/export/%0.1f/%s?&apikey=%s%s';
    /**
     * {@inheritdoc}
     */
    protected $apiVersion = 1.0;

    /**
     * {@inheritdoc}
     */
    public function call($method, array $params = array(), $format = self::FORMAT_JSON)
    {
        return $this->getAdapter()->getContent(
            sprintf(
                $this::API_URL,
                $this->getDc(),
                $this->getApiVersion(),
                $method,
                $this->getApiKey(),
                $this->paramsQueryStringBuilder($params)
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function paramsQueryStringBuilder(array $params)
    {
        $paramsString = "";
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = http_build_query($value);
            }
            $paramsString .= "&$key=$value";
        }

        return $paramsString;
    }
}
