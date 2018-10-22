<?php
/***************************************************************************
 *   Copyright (C) 2007 by Dmitry A. Lomash, Dmitry E. Demidov             *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

namespace Onphp;

/**
 * @ingroup Feed
 **/
class YandexRssChannelWorker extends Singleton implements FeedChannelWorker
{
    // XML Declaration
    const XML_DECLARATION = '<?xml version="1.0" encoding="UTF-8"?>';

    /**
     * @return RssChannelWorker
     **/
    public static function me()
    {
        return Singleton::getInstance(__CLASS__);
    }

    /**
     * @return FeedChannel
     **/
    public function makeChannel(\SimpleXMLElement $xmlFeed)
    {
        if (
            (!isset($xmlFeed->channel))
            || (!isset($xmlFeed->channel->title))
        ) {
            throw new WrongStateException(
                'there are no channels in given rss'
            );
        }

        $feedChannel =
            new FeedChannel((string)$xmlFeed->channel->title);

        if (isset($xmlFeed->channel->link)) {
            $feedChannel->setLink((string)$xmlFeed->channel->link);
        }

        return $feedChannel;
    }

    public function toXml(FeedChannel $channel, $itemsXml)
    {
        return
            self::XML_DECLARATION . "\n"
            . '<rss version="' . RssFeedFormat::VERSION . '" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/" xmlns:yandex="http://news.yandex.ru" xmlns:turbo="http://turbo.yandex.ru">'
            . '<channel>'
            . '<title>' . $channel->getTitle() . '</title>'
            . ($channel->getLink()
               ? '<link>' . $channel->getLink() . '</link>'
               : null)
            . ($channel->getLogo()
               ? '<yandex:logo>'.$channel->getLogo().'</yandex:logo>'
               : null)
            . ($channel->getLogoSquare()
               ? '<yandex:logo type="square">'.$channel->getLogoSquare().'</yandex:logo>'
               : null)
            . ($channel->getDescription()
               ?
               '<description>'
               . $channel->getDescription()
               . '</description>'
               : null)
            . ($channel->getLanguage()
               ?
               '<language>'
               . $channel->getLanguage()
               . '</language>'
               : null)
            . ($channel->getAnalytics()
               ?
               '<yandex:analytics type="' . $channel->getAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getLiveInternetAnalytics()
               ?
               '<yandex:analytics type="LiveInternet" params="' . $channel->getLiveInternetAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getYandexAnalytics()
               ? implode(array_map(
                   function($id) {
                       return '<yandex:analytics type="Yandex" id="' . $id . '"></yandex:analytics>';
                   }, $channel->getYandexAnalytics()
               ))
               : null)
            . ($channel->getYandexAdNetworkId()
               ?
               '<yandex:adNetwork type="Yandex" id="' . $channel->getYandexAdNetworkId() . '"></yandex:adNetwork>'
               : null)
            . (count($channel->getYandexAds())
               ?
               implode('', array_map(function($el) {
                   return '<yandex:adNetwork type="' . $el['type'] . '" id="' . $el['id'] . '"'
                       . ($el['turbo-ad-id'] ? ' turbo-ad-id="' . $el['turbo-ad-id'] . '"' : null) . '></yandex:adNetwork>';
               }, $channel->getYandexAds()))
               : null)
            . ($channel->getGoogleAnalytics()
               ?
               '<yandex:analytics type="Google" id="' . $channel->getGoogleAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getMailRuAnalytics()
               ?
               '<yandex:analytics type="MailRu" id="' . $channel->getMailRuAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getRamblerAnalytics()
               ?
               '<yandex:analytics type="Rambler" id="' . $channel->getRamblerAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getMediascopeAnalytics()
               ?
               '<yandex:analytics type="Mediascope" id="' . $channel->getMediascopeAnalytics() . '"></yandex:analytics>'
               : null)
            . ($channel->getLastBuildDate()
               ?
               '<lastBuildDate>'
               . date('r', $channel->getLastBuildDate()->toStamp())
               . '</lastBuildDate>'
               : null)
            . $itemsXml
            . '</channel>'
            . '</rss>';
    }
}
