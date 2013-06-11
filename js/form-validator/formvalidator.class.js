/*
 * Form validator Javascript class
 */

var FormValidator = function(formName) {
	FormValidator.ON_LEAVE = 1;
	FormValidator.ON_TYPE  = 2;

	var that = this;
	var formElementValidatorRegistry = {};
	var validationFaults = {};

	var setOnBlur = function(item, validatorItem) {
		var prevOnBlur = item.onblur;
		item.onblur = function() {
			if (prevOnBlur) { prevOnBlur(); }
			if (item.value == "") { return true; } // required validation triggered on submit
			if (!formElementValidatorRegistry[validatorItem].validator(this.value)) {
				_addClass(this, "error");
				this.title = formElementValidatorRegistry[validatorItem].invalidMessage;
				validationFaults[this.name] = validatorItem;
			}
			else {
				_removeClass(this, "error");
				this.title = "";
				validationFaults[this.name] = false;
			}
		}
	};
	
	var setOnKeyDown = function(item, validatorItem) {
		var prevOnKeyDown = item.onkeypress;
		item.onkeypress = function(e) {
			var evt = e || window.event;
			var pressed = evt.keyCode || evt.which;
			if (prevOnKeyDown) { prevOnKeyDown(); }
			if (pressed <= 32) { return true; }
			return formElementValidatorRegistry[validatorItem].validator(pressed);

		}
	};

	this.formRef = document.getElementsByName(formName)[0];
	this.initValidation = function() {
		setDefaultValidators();
		var prevonsubmit = this.formRef.onsubmit;
		this.formRef.onsubmit = function() {
			if (prevonsubmit) { prevonsubmit(); }
			var hasErrors = false;
			for (var i = 0; i < this.elements.length; i++) {
				if (_hasClass(this.elements[i], "required")) {
					if (!that.validateRequired(this.elements[i].value)) { _addClass(this.elements[i], "error"); }
					else if (!validationFaults[this.elements[i].name]) {
						_removeClass(this.elements[i], "error");
					}
				}
				if (_hasClass(this.elements[i], "error")) {
					hasErrors = true;
				}
			}
			return !hasErrors;

		};
		for (var i = 0; i < this.formRef.elements.length; i++) {
			for (var validatorItem in formElementValidatorRegistry) {
	//			if (!(formElementValidatorRegistry[validatorItem].validator && formElementValidatorRegistry[validatorItem].type)) { continue; }
				if (_hasClass(this.formRef.elements[i], validatorItem)) {
					switch (formElementValidatorRegistry[validatorItem].type) {
						case FormValidator.ON_LEAVE : {
							setOnBlur(this.formRef.elements[i], validatorItem);
							break;
						}
						case FormValidator.ON_TYPE : {
							setOnKeyDown(this.formRef.elements[i], validatorItem);
							break;
						}
					}
				}
			}
		}
	};

	var _hasClass = function(item, className) {
		var classlist = item.className.split(" ");
		for (var i = 0; i < classlist.length; i++) {
			if (classlist[i] == className) { return true; }
		}
		return false;
	};

	var _addClass = function(item, className) {
		if (!_hasClass(item, className)) { item.className += " " + className; }
	};

	var _removeClass = function(item, className) {
		if (_hasClass(item, className)) {
			var classList = item.className.split(" ");
			for (i = 0; i < classList.length; i++) {
				if (classList[i] == className) {
					classList.splice(i, 1);
					break;
				}
			}
			item.className = classList.join(" ");
		}
	};
	
	this.validateEmail = function(str) {
		return /[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i.test(str);
	}
	;
	this.validateNumber = function(keyCode) {
		return keyCode >= 48 && keyCode <= 57;
	};
	
	this.validateLink = function(str) {
		return str.indexOf("http://") == 0;
	};

	var isControlKey = function(keyCode) {
		var ctrlKeys = [8, 9, 13];
		for (var i = 0; i < ctrlKeys; i++) { if (ctrlKeys[i] == keyCode) { return true; } }
		return false;
	};

	var customFormElementValidatorRegistry = {};
	this.registerValidator = function(className, _type, msg, fn) {
		customFormElementValidatorRegistry[className] = {
			validator      : fn,
			type           : _type,
			invalidMessage : msg
		};
	};

	this.validateRequired = function(str) {
		if (str.length == 0) { return false; }
		return /[?a-zA-Zа-€ј-я0-9_-]{2,20}$/.test(str);

	};

	var setDefaultValidators = function() {
		formElementValidatorRegistry = {
			emailValidator  : { validator : that.validateEmail,  type : FormValidator.ON_LEAVE, invalidMessage : "ќшибочный E-mail адрес" },
			linkValidator   : { validator : that.validateLink,   type : FormValidator.ON_LEAVE, invalidMessage : "Invalid http link"     },
			numberValidator : { validator : that.validateNumber, type : FormValidator.ON_TYPE  } // on_type validator does not need a message
		};
		for (var fv in customFormElementValidatorRegistry) {
			formElementValidatorRegistry[fv] = {};
			formElementValidatorRegistry[fv].validator      = customFormElementValidatorRegistry[fv].validator;
			formElementValidatorRegistry[fv].type           = customFormElementValidatorRegistry[fv].type;
			formElementValidatorRegistry[fv].invalidMessage = customFormElementValidatorRegistry[fv].invalidMessage;
		}
	}
};
