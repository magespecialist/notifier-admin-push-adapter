/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

'use strict';

define([
    'uiComponent',
    'jquery',
    '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'
], function (Component, $, toastr) {
    return Component.extend({
        defaults: {
            url: ''
        },

        allowedMessagesOrigin: null,
        broadcastChannel: null,

        initialize: function () {
            this._super();

            if (
                typeof(BroadcastChannel) !== "undefined" &&
                typeof(EventSource) !== "undefined" &&
                ("Notification" in window)
            ) {
                this.initEventSource();
                this.initBrowserNotificationTrapper()
            } else {
                console.log('MSP Notifier Admin Push is not supported by this browser');
            }
        },

        /**
         * Initialize event source
         */
        initEventSource: function () {
            var me = this;
            var source = new EventSource(this.url);

            source.onmessage = function(event) {
                me.notifyEvent(JSON.parse(event.data));
            };
        },

        /**
         * Initialize browser notification trapper
         */
        initBrowserNotificationTrapper: function () {
            var me, parser;

            parser = document.createElement('a');
            parser.href = this.iframeUrl;

            this.allowedMessagesOrigin = parser.protocol + '//' + parser.hostname;

            this.broadcastChannel = new BroadcastChannel('msp_notifier_admin_push');
            me = this;

            this.broadcastChannel.onmessage = function (event) {
                if (event.origin === me.allowedMessagesOrigin) {
                    me.trapBrowserNotification(event.data);
                }
            };
        },

        /**
         * @param {Object} pushNotification
         */
        showSystemNotification: function (pushNotification) {
            var notification, message;

            message = {
                body: pushNotification.message,
                icon: pushNotification.icon,
                requireInteraction: true
            };

            notification = new Notification(pushNotification.title, message);
            if (pushNotification.dismiss > 0) {
                setTimeout(notification.close.bind(notification), pushNotification.dismiss * 1000);
            }
        },

        /**
         * @param {Object} pushNotification
         */
        trapBrowserNotification: function (pushNotification) {
            var title, message, options;

            title = pushNotification.title;
            message = pushNotification.message;
            options = {
                "preventDuplicates": true,
                "positionClass": "toast-bottom-right",
                "closeButton": true,
                "newestOnTop": true
            };

            if (pushNotification.dismiss) {
                options['timeOut'] = pushNotification.dismiss * 1000;
                options['progressBar'] = true;
            } else {
                options['timeOut'] = 600000;
                options['progressBar'] = false;
            }

            // Strip HTML
            message = $('<p></p>').text(message).html().split(/[\n\r]/).join('<br />');

            switch (pushNotification.level) {
                case 'success':
                    toastr.success(message, title, options);
                    break;

                case 'warning':
                    toastr.warning(message, title, options);
                    break;

                case 'error':
                    toastr.error(message, title, options);
                    break;

                default:
                    toastr.info(message, title, options);
                    break;
            }
        },

        /**
         * Broadcast to all open windows
         * @param {Object} pushNotification
         */
        showBrowserNotification: function (pushNotification) {
            this.broadcastChannel.postMessage(pushNotification);
            this.trapBrowserNotification(pushNotification);
        },

        /**
         * @param {Object} pushNotification
         */
        notifyEvent: function (pushNotification) {
            var me = this;

            if (pushNotification.mode.indexOf('system') !== -1) {
                if (Notification.permission === "granted") {
                    this.showSystemNotification(pushNotification);
                }

                else if (Notification.permission !== 'denied') {
                    Notification.requestPermission(function (permission) {
                        if (permission === "granted") {
                            me.showSystemNotification(pushNotification);
                        }
                    });
                }
            }

            if (pushNotification.mode.indexOf('browser') !== -1) {
                this.showBrowserNotification(pushNotification);
            }
        }
    });
});
