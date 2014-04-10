// JavaScript Document
function Nesh(){
	//Private variables.
	var sid;
	var hash;
	var events = {//"key1" = "value1", "key2" = "value2"
				  };
	var tags = {//"key1" = "value1", "key2" = "value2"
				};
				
	var _log = [];
	var errlog = [];	
	
	//Public Variables
	//this.variable = value;
	
	//Private methods
	//var funcName = function(){}
	
	//Public methods of the class
	this.save = function(){
		//save object to localStorage
	}
	
	this._load  = function(){
		//load object from localStorage
	}
	
	this.get_sid = function(){
		return sid; //return the private variable
	}
	
	this.getUniqueSid = function(){
		//ajax call to server to get a unique session id
	}
	
	this.sidSuccess = function(){
		//ajax return handler
	}
	
	this.sidError = function(){
		//ajax return error handler
	}
	
	this.postEvent = function(){
		//ajax call to server with new event
	}
	
	this.postSuccess = function(){
		//ajax return handler
	}
	
	this.postError = function(){
		//ajax return error handler
	}
}