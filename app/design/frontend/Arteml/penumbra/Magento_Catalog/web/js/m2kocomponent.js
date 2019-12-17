define(['jquery', 'uiComponent', 'ko', 'rgbModel'], function ($, Component, ko, rgbModel) {
    'use strict';

    var self;

    return Component.extend({
        myTimer: ko.observable(0), randomColour: ko.computed(function () {
            return 'rgb(' + rgbModel.red() + ', ' + rgbModel.blue() + ', ' + rgbModel.green() + ')';
        }, this), initialize: function () {
            self = this;
            this._super();
            this.incrementTime();
            this.subscribeToTime();
        }, incrementTime: function () {
            var t = 0;

            setInterval(function () {
                t++;
                self.myTimer(t);
            }, 1000);
        }, subscribeToTime: function () {
            this.myTimer.subscribe(function () {
                rgbModel.updateColour();
            });
        }
    });
});