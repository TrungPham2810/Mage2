define(['jquery', 'uiComponent', 'ko'], function ($, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'OpenTechiz_AdminNote/knockout-test'
            },
            initialize: function () {
                this.listName = ko.observableArray([
                    {name:'ok'},
                    {name:'di'},
                    {name:'em'},
                ]);
                this.customerName = ko.observableArray([]);
                this.customerData = ko.observable('');
                this._super();

                this.testCallFunction();
            },
            testCallFunction: function() {
                var self = this;
                console.log('testCallFunction');
                console.log(111111);
                $('body').find('.add').click(function () {
                    var content = $(this).html();
                    self.listName.push({name:content});
                });

                $('body').find('.delete').click(function () {
                    var content = $(this).html();
                    var listName =  self.listName();
                    console.log(listName);
                    const index = self.listName().findIndex(prop => prop.name === content);
                    console.log(index);
                    if (index >= 0) {
                        self.listName.splice(index,1)
                    }
                });

            },
            addNewCustomer: function () {
                console.log(this.listName());
                console.log(this.customerName());
                console.log(this.customerData());
                this.customerName.push({name:this.customerData()});
                this.customerData('');
            }
        });
    }
);
