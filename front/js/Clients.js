function ClientModel(){

    var self = this;
    self.url = "http://www.moravia.intra/clients/add?callback=receive";

    self.clients = ko.observableArray();
    self.name = ko.observable();
    self.lastName = ko.observable();
    self.age = ko.observable();
    self.showForm = ko.observable(false);

    self.list = function(){
      var url = "http://www.moravia.intra/clients?callback=receive";

      $.ajax({
          type: 'GET',
          url: url,
          async: false,
          crossDomain: true,
          jsonp: false,
          jsonpCallback: "receive",
          dataType: 'jsonp'
      }).success(function(data){
        self.clients(data);
      }).error(function(jqXHR, status, responseText){
         console.log(status, responseText);
      });

    },

    self.removeClient = function(id){

      var url = "http://www.moravia.intra/clients/remove?callback=receive";

      var data = {
        id: id
      }
      
      $.ajax({
          type: 'GET',
          url: url,
          data: data,
          async: false,
          crossDomain: true,
          jsonp: false,
          jsonpCallback: "receive",
          dataType: 'jsonp'
      }).success(function(data){
        self.list();
      }).error(function(jqXHR, status, responseText){
         console.log(status, responseText);
      });

    },

    self.addNewClient = function(){

      var data = {
        name: self.name(),
        lastName: self.lastName(),
        age: self.age()
      }
      
      $.ajax({
          type: 'GET',
          url: self.url,
          data: data,
          async: false,
          crossDomain: true,
          jsonp: false,
          jsonpCallback: "receive",
          dataType: 'jsonp'
      }).success(function(data){
        self.list();
        self.clearFields();
      }).error(function(jqXHR, status, responseText){
         console.log(status, responseText);
      });

    }

    self.clearFields = function(){
      self.name('');
      self.lastName('');
      self.age('');
    }

    self.availableForm = function(){
      if (self.showForm()) {
        self.showForm(false);
      } else {
        self.showForm(true);
      }
    }

    self.showFullName = function(data){
      return data.name + ' ' + data.lastname;
    }

}

var clientsModel = new ClientModel();
ko.applyBindings(clientsModel);
clientsModel.list();