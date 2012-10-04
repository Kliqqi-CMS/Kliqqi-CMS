var Prototype = { Version: '1.5.0_rc0', ScriptFragment: '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)', emptyFunction: function() {}, K: function(x) {return x}
}
var Class = { create: function() { return function() { this.initialize.apply(this, arguments);}
}
}
var Abstract = new Object(); Object.extend = function(destination, source) { for (var property in source) { destination[property] = source[property];}
return destination;}
Object.inspect = function(object) { try { if (object == undefined) return 'undefined'; if (object == null) return 'null'; return object.inspect ? object.inspect() : object.toString();} catch (e) { if (e instanceof RangeError) return '...'; throw e;}
}
Function.prototype.bind = function() { var __method = this, args = $A(arguments), object = args.shift(); return function() { return __method.apply(object, args.concat($A(arguments)));}
}
Function.prototype.bindAsEventListener = function(object) { var __method = this; return function(event) { return __method.call(object, event || window.event);}
}
Object.extend(Number.prototype, { toColorPart: function() { var digits = this.toString(16); if (this < 16) return '0' + digits; return digits;}, succ: function() { return this + 1;}, times: function(iterator) { $R(0, this, true).each(iterator); return this;}
}); var Try = { these: function() { var returnValue; for (var i = 0; i < arguments.length; i++) { var lambda = arguments[i]; try { returnValue = lambda(); break;} catch (e) {}
}
return returnValue;}
}
var PeriodicalExecuter = Class.create(); PeriodicalExecuter.prototype = { initialize: function(callback, frequency) { this.callback = callback; this.frequency = frequency; this.currentlyExecuting = false; this.registerCallback();}, registerCallback: function() { setInterval(this.onTimerEvent.bind(this), this.frequency * 1000);}, onTimerEvent: function() { if (!this.currentlyExecuting) { try { this.currentlyExecuting = true; this.callback();} finally { this.currentlyExecuting = false;}
}
}
}
Object.extend(String.prototype, { gsub: function(pattern, replacement) { var result = '', source = this, match; replacement = arguments.callee.prepareReplacement(replacement); while (source.length > 0) { if (match = source.match(pattern)) { result += source.slice(0, match.index); result += (replacement(match) || '').toString(); source = source.slice(match.index + match[0].length);} else { result += source, source = '';}
}
return result;}, sub: function(pattern, replacement, count) { replacement = this.gsub.prepareReplacement(replacement); count = count === undefined ? 1 : count; return this.gsub(pattern, function(match) { if (--count < 0) return match[0]; return replacement(match);});}, scan: function(pattern, iterator) { this.gsub(pattern, iterator); return this;}, truncate: function(length, truncation) { length = length || 30; truncation = truncation === undefined ? '...' : truncation; return this.length > length ?
this.slice(0, length - truncation.length) + truncation : this;}, strip: function() { return this.replace(/^\s+/, '').replace(/\s+$/, '');}, stripTags: function() { return this.replace(/<\/?[^>]+>/gi, '');}, stripScripts: function() { return this.replace(new RegExp(Prototype.ScriptFragment, 'img'), '');}, extractScripts: function() { var matchAll = new RegExp(Prototype.ScriptFragment, 'img'); var matchOne = new RegExp(Prototype.ScriptFragment, 'im'); return (this.match(matchAll) || []).map(function(scriptTag) { return (scriptTag.match(matchOne) || ['', ''])[1];});}, evalScripts: function() { return this.extractScripts().map(function(script) { return eval(script) });}, escapeHTML: function() { var div = document.createElement('div'); var text = document.createTextNode(this); div.appendChild(text); return div.innerHTML;}, unescapeHTML: function() { var div = document.createElement('div'); div.innerHTML = this.stripTags(); return div.childNodes[0] ? div.childNodes[0].nodeValue : '';}, toQueryParams: function() { var pairs = this.match(/^\??(.*)$/)[1].split('&'); return pairs.inject({}, function(params, pairString) { var pair = pairString.split('='); params[pair[0]] = pair[1]; return params;});}, toArray: function() { return this.split('');}, camelize: function() { var oStringList = this.split('-'); if (oStringList.length == 1) return oStringList[0]; var camelizedString = this.indexOf('-') == 0
? oStringList[0].charAt(0).toUpperCase() + oStringList[0].substring(1)
: oStringList[0]; for (var i = 1, len = oStringList.length; i < len; i++) { var s = oStringList[i]; camelizedString += s.charAt(0).toUpperCase() + s.substring(1);}
return camelizedString;}, inspect: function() { return "'" + this.replace(/\\/g, '\\\\').replace(/'/g, '\\\'') + "'";
  }
});

String.prototype.gsub.prepareReplacement = function(replacement) {
  if (typeof replacement == 'function') return replacement;
  var template = new Template(replacement);
  return function(match) { return template.evaluate(match) };
}

String.prototype.parseQuery = String.prototype.toQueryParams;

var Template = Class.create();
Template.Pattern = /(^|.|\r|\n)(#\{(.*?)\})/;
Template.prototype = {
  initialize: function(template, pattern) {
    this.template = template.toString();
    this.pattern  = pattern || Template.Pattern;
  },

  evaluate: function(object) {
    return this.template.gsub(this.pattern, function(match) {
      var before = match[1];
      if (before == '\\') return match[2];
      return before + (object[match[3]] || '').toString();
    });
  }
}

var $break    = new Object();
var $continue = new Object();

var Enumerable = {
  each: function(iterator) {
    var index = 0;
    try {
      this._each(function(value) {
        try {
          iterator(value, index++);
        } catch (e) {
          if (e != $continue) throw e;
        }
      });
    } catch (e) {
      if (e != $break) throw e;
    }
  },

  all: function(iterator) {
    var result = true;
    this.each(function(value, index) {
      result = result && !!(iterator || Prototype.K)(value, index);
      if (!result) throw $break;
    });
    return result;
  },

  any: function(iterator) {
    var result = true;
    this.each(function(value, index) {
      if (result = !!(iterator || Prototype.K)(value, index))
        throw $break;
    });
    return result;
  },

  collect: function(iterator) {
    var results = [];
    this.each(function(value, index) {
      results.push(iterator(value, index));
    });
    return results;
  },

  detect: function (iterator) {
    var result;
    this.each(function(value, index) {
      if (iterator(value, index)) {
        result = value;
        throw $break;
      }
    });
    return result;
  },

  findAll: function(iterator) {
    var results = [];
    this.each(function(value, index) {
      if (iterator(value, index))
        results.push(value);
    });
    return results;
  },

  grep: function(pattern, iterator) {
    var results = [];
    this.each(function(value, index) {
      var stringValue = value.toString();
      if (stringValue.match(pattern))
        results.push((iterator || Prototype.K)(value, index));
    })
    return results;
  },

  include: function(object) {
    var found = false;
    this.each(function(value) {
      if (value == object) {
        found = true;
        throw $break;
      }
    });
    return found;
  },

  inject: function(memo, iterator) {
    this.each(function(value, index) {
      memo = iterator(memo, value, index);
    });
    return memo;
  },

  invoke: function(method) {
    var args = $A(arguments).slice(1);
    return this.collect(function(value) {
      return value[method].apply(value, args);
    });
  },

  max: function(iterator) {
    var result;
    this.each(function(value, index) {
      value = (iterator || Prototype.K)(value, index);
      if (result == undefined || value >= result)
        result = value;
    });
    return result;
  },

  min: function(iterator) {
    var result;
    this.each(function(value, index) {
      value = (iterator || Prototype.K)(value, index);
      if (result == undefined || value < result)
        result = value;
    });
    return result;
  },

  partition: function(iterator) {
    var trues = [], falses = [];
    this.each(function(value, index) {
      ((iterator || Prototype.K)(value, index) ?
        trues : falses).push(value);
    });
    return [trues, falses];
  },

  pluck: function(property) {
    var results = [];
    this.each(function(value, index) {
      results.push(value[property]);
    });
    return results;
  },

  reject: function(iterator) {
    var results = [];
    this.each(function(value, index) {
      if (!iterator(value, index))
        results.push(value);
    });
    return results;
  },

  sortBy: function(iterator) {
    return this.collect(function(value, index) {
      return {value: value, criteria: iterator(value, index)};
    }).sort(function(left, right) {
      var a = left.criteria, b = right.criteria;
      return a < b ? -1 : a > b ? 1 : 0;
    }).pluck('value');
  },

  toArray: function() {
    return this.collect(Prototype.K);
  },

  zip: function() {
    var iterator = Prototype.K, args = $A(arguments);
    if (typeof args.last() == 'function')
      iterator = args.pop();

    var collections = [this].concat(args).map($A);
    return this.map(function(value, index) {
      return iterator(collections.pluck(index));
    });
  },

  inspect: function() {
    return '#<Enumerable:' + this.toArray().inspect() + '>';
  }
}

Object.extend(Enumerable, {
  map:     Enumerable.collect,
  find:    Enumerable.detect,
  select:  Enumerable.findAll,
  member:  Enumerable.include,
  entries: Enumerable.toArray
});
var $A = Array.from = function(iterable) {
  if (!iterable) return [];
  if (iterable.toArray) {
    return iterable.toArray();
  } else {
    var results = [];
    for (var i = 0; i < iterable.length; i++)
      results.push(iterable[i]);
    return results;
  }
}

Object.extend(Array.prototype, Enumerable);

if (!Array.prototype._reverse)
  Array.prototype._reverse = Array.prototype.reverse;

Object.extend(Array.prototype, {
  _each: function(iterator) {
    for (var i = 0; i < this.length; i++)
      iterator(this[i]);
  },

  clear: function() {
    this.length = 0;
    return this;
  },

  first: function() {
    return this[0];
  },

  last: function() {
    return this[this.length - 1];
  },

  compact: function() {
    return this.select(function(value) {
      return value != undefined || value != null;
    });
  },

  flatten: function() {
    return this.inject([], function(array, value) {
      return array.concat(value && value.constructor == Array ?
        value.flatten() : [value]);
    });
  },

  without: function() {
    var values = $A(arguments);
    return this.select(function(value) {
      return !values.include(value);
    });
  },

  indexOf: function(object) {
    for (var i = 0; i < this.length; i++)
      if (this[i] == object) return i;
    return -1;
  },

  reverse: function(inline) {
    return (inline !== false ? this : this.toArray())._reverse();
  },

  inspect: function() {
    return '[' + this.map(Object.inspect).join(', ') + ']';
  }
});
var Hash = {
  _each: function(iterator) {
    for (var key in this) {
      var value = this[key];
      if (typeof value == 'function') continue;

      var pair = [key, value];
      pair.key = key;
      pair.value = value;
      iterator(pair);
    }
  },

  keys: function() {
    return this.pluck('key');
  },

  values: function() {
    return this.pluck('value');
  },

  merge: function(hash) {
    return $H(hash).inject($H(this), function(mergedHash, pair) {
      mergedHash[pair.key] = pair.value;
      return mergedHash;
    });
  },

  toQueryString: function() {
    return this.map(function(pair) {
      return pair.map(encodeURIComponent).join('=');
    }).join('&');
  },

  inspect: function() {
    return '#<Hash:{' + this.map(function(pair) {
      return pair.map(Object.inspect).join(': ');
    }).join(', ') + '}>';
  }
}

function $H(object) {
  var hash = Object.extend({}, object || {});
  Object.extend(hash, Enumerable);
  Object.extend(hash, Hash);
  return hash;
}
ObjectRange = Class.create();
Object.extend(ObjectRange.prototype, Enumerable);
Object.extend(ObjectRange.prototype, {
  initialize: function(start, end, exclusive) {
    this.start = start;
    this.end = end;
    this.exclusive = exclusive;
  },

  _each: function(iterator) {
    var value = this.start;
    do {
      iterator(value);
      value = value.succ();
    } while (this.include(value));
  },

  include: function(value) {
    if (value < this.start)
      return false;
    if (this.exclusive)
      return value < this.end;
    return value <= this.end;
  }
});

var $R = function(start, end, exclusive) {
  return new ObjectRange(start, end, exclusive);
}

var Ajax = {
  getTransport: function() {
    return Try.these(
      function() {return new XMLHttpRequest()},
      function() {return new ActiveXObject('Msxml2.XMLHTTP')},
      function() {return new ActiveXObject('Microsoft.XMLHTTP')}
    ) || false;
  },

  activeRequestCount: 0
}

Ajax.Responders = {
  responders: [],

  _each: function(iterator) {
    this.responders._each(iterator);
  },

  register: function(responderToAdd) {
    if (!this.include(responderToAdd))
      this.responders.push(responderToAdd);
  },

  unregister: function(responderToRemove) {
    this.responders = this.responders.without(responderToRemove);
  },

  dispatch: function(callback, request, transport, json) {
    this.each(function(responder) {
      if (responder[callback] && typeof responder[callback] == 'function') {
        try {
          responder[callback].apply(responder, [request, transport, json]);
        } catch (e) {}
      }
    });
  }
};

Object.extend(Ajax.Responders, Enumerable);

Ajax.Responders.register({
  onCreate: function() {
    Ajax.activeRequestCount++;
  },

  onComplete: function() {
    Ajax.activeRequestCount--;
  }
});

Ajax.Base = function() {};
Ajax.Base.prototype = {
  setOptions: function(options) {
    this.options = {
      method:       'post',
      asynchronous: true,
      contentType:  'application/x-www-form-urlencoded',
      parameters:   ''
    }
    Object.extend(this.options, options || {});
  },

  responseIsSuccess: function() {
    return this.transport.status == undefined
        || this.transport.status == 0
        || (this.transport.status >= 200 && this.transport.status < 300);
  },

  responseIsFailure: function() {
    return !this.responseIsSuccess();
  }
}

Ajax.Request = Class.create();
Ajax.Request.Events =
  ['Uninitialized', 'Loading', 'Loaded', 'Interactive', 'Complete'];

Ajax.Request.prototype = Object.extend(new Ajax.Base(), {
  initialize: function(url, options) {
    this.transport = Ajax.getTransport();
    this.setOptions(options);
    this.request(url);
  },

  request: function(url) {
    var parameters = this.options.parameters || '';
    if (parameters.length > 0) parameters += '&_=';

    try {
      this.url = url;
      if (this.options.method == 'get' && parameters.length > 0)
        this.url += (this.url.match(/\?/) ? '&' : '?') + parameters;

      Ajax.Responders.dispatch('onCreate', this, this.transport);

      this.transport.open(this.options.method, this.url,
        this.options.asynchronous);

      if (this.options.asynchronous) {
        this.transport.onreadystatechange = this.onStateChange.bind(this);
        setTimeout((function() {this.respondToReadyState(1)}).bind(this), 10);
      }

      this.setRequestHeaders();

      var body = this.options.postBody ? this.options.postBody : parameters;
      this.transport.send(this.options.method == 'post' ? body : null);

    } catch (e) {
      this.dispatchException(e);
    }
  },

  setRequestHeaders: function() {
    var requestHeaders =
      ['X-Requested-With', 'XMLHttpRequest',
       'X-Prototype-Version', Prototype.Version,
       'Accept', 'text/javascript, text/html, application/xml, text/xml, */*'];

    if (this.options.method == 'post') {
      requestHeaders.push('Content-type', this.options.contentType);

      /* Force "Connection: close" for Mozilla browsers to work around
       * a bug where XMLHttpReqeuest sends an incorrect Content-length
       * header. See Mozilla Bugzilla #246651.
       */
      if (this.transport.overrideMimeType)
        requestHeaders.push('Connection', 'close');
    }

    if (this.options.requestHeaders)
      requestHeaders.push.apply(requestHeaders, this.options.requestHeaders);

    for (var i = 0; i < requestHeaders.length; i += 2)
      this.transport.setRequestHeader(requestHeaders[i], requestHeaders[i+1]);
  },

  onStateChange: function() {
    var readyState = this.transport.readyState;
    if (readyState != 1)
      this.respondToReadyState(this.transport.readyState);
  },

  header: function(name) {
    try {
      return this.transport.getResponseHeader(name);
    } catch (e) {}
  },

  evalJSON: function() {
    try {
      return eval('(' + this.header('X-JSON') + ')');
    } catch (e) {}
  },

  evalResponse: function() {
    try {
      return eval(this.transport.responseText);
    } catch (e) {
      this.dispatchException(e);
    }
  },

  respondToReadyState: function(readyState) {
    var event = Ajax.Request.Events[readyState];
    var transport = this.transport, json = this.evalJSON();

    if (event == 'Complete') {
      try {
        (this.options['on' + this.transport.status]
         || this.options['on' + (this.responseIsSuccess() ? 'Success' : 'Failure')]
         || Prototype.emptyFunction)(transport, json);
      } catch (e) {
        this.dispatchException(e);
      }

      if ((this.header('Content-type') || '').match(/^text\/javascript/i))
        this.evalResponse();
    }

    try {
      (this.options['on' + event] || Prototype.emptyFunction)(transport, json);
      Ajax.Responders.dispatch('on' + event, this, transport, json);
    } catch (e) {
      this.dispatchException(e);
    }

    /* Avoid memory leak in MSIE: clean up the oncomplete event handler */
    if (event == 'Complete')
      this.transport.onreadystatechange = Prototype.emptyFunction;
  },

  dispatchException: function(exception) {
    (this.options.onException || Prototype.emptyFunction)(this, exception);
    Ajax.Responders.dispatch('onException', this, exception);
  }
});

Ajax.Updater = Class.create();

Object.extend(Object.extend(Ajax.Updater.prototype, Ajax.Request.prototype), {
  initialize: function(container, url, options) {
    this.containers = {
      success: container.success ? $(container.success) : $(container),
      failure: container.failure ? $(container.failure) :
        (container.success ? null : $(container))
    }

    this.transport = Ajax.getTransport();
    this.setOptions(options);

    var onComplete = this.options.onComplete || Prototype.emptyFunction;
    this.options.onComplete = (function(transport, object) {
      this.updateContent();
      onComplete(transport, object);
    }).bind(this);

    this.request(url);
  },

  updateContent: function() {
    var receiver = this.responseIsSuccess() ?
      this.containers.success : this.containers.failure;
    var response = this.transport.responseText;

    if (!this.options.evalScripts)
      response = response.stripScripts();

    if (receiver) {
      if (this.options.insertion) {
        new this.options.insertion(receiver, response);
      } else {
        Element.update(receiver, response);
      }
    }

    if (this.responseIsSuccess()) {
      if (this.onComplete)
        setTimeout(this.onComplete.bind(this), 10);
    }
  }
});

Ajax.PeriodicalUpdater = Class.create();
Ajax.PeriodicalUpdater.prototype = Object.extend(new Ajax.Base(), {
  initialize: function(container, url, options) {
    this.setOptions(options);
    this.onComplete = this.options.onComplete;

    this.frequency = (this.options.frequency || 2);
    this.decay = (this.options.decay || 1);

    this.updater = {};
    this.container = container;
    this.url = url;

    this.start();
  },

  start: function() {
    this.options.onComplete = this.updateComplete.bind(this);
    this.onTimerEvent();
  },

  stop: function() {
    this.updater.onComplete = undefined;
    clearTimeout(this.timer);
    (this.onComplete || Prototype.emptyFunction).apply(this, arguments);
  },

  updateComplete: function(request) {
    if (this.options.decay) {
      this.decay = (request.responseText == this.lastText ?
        this.decay * this.options.decay : 1);

      this.lastText = request.responseText;
    }
    this.timer = setTimeout(this.onTimerEvent.bind(this),
      this.decay * this.frequency * 1000);
  },

  onTimerEvent: function() {
    this.updater = new Ajax.Updater(this.container, this.url, this.options);
  }
});
function $() {
  var results = [], element;
  for (var i = 0; i < arguments.length; i++) {
    element = arguments[i];
    if (typeof element == 'string')
      element = document.getElementById(element);
    results.push(Element.extend(element));
  }
  return results.length < 2 ? results[0] : results;
}

document.getElementsByClassName = function(className, parentElement) {
  var children = ($(parentElement) || document.body).getElementsByTagName('*');
  return $A(children).inject([], function(elements, child) {
    if (child.className.match(new RegExp("(^|\\s)" + className + "(\\s|$)")))
      elements.push(Element.extend(child));
    return elements;
  });
}

/*--------------------------------------------------------------------------*/

if (!window.Element)
  var Element = new Object();

Element.extend = function(element) {
  if (!element) return;
  if (_nativeExtensions) return element;

  if (!element._extended && element.tagName && element != window) {
    var methods = Element.Methods, cache = Element.extend.cache;
    for (property in methods) {
      var value = methods[property];
      if (typeof value == 'function')
        element[property] = cache.findOrStore(value);
    }
  }

  element._extended = true;
  return element;
}

Element.extend.cache = {
  findOrStore: function(value) {
    return this[value] = this[value] || function() {
      return value.apply(null, [this].concat($A(arguments)));
    }
  }
}

Element.Methods = {
  visible: function(element) {
    return $(element).style.display != 'none';
  },

  toggle: function() {
    for (var i = 0; i < arguments.length; i++) {
      var element = $(arguments[i]);
      Element[Element.visible(element) ? 'hide' : 'show'](element);
    }
  },

  hide: function() {
    for (var i = 0; i < arguments.length; i++) {
      var element = $(arguments[i]);
      element.style.display = 'none';
    }
  },

  show: function() {
    for (var i = 0; i < arguments.length; i++) {
      var element = $(arguments[i]);
      element.style.display = '';
    }
  },

  remove: function(element) {
    element = $(element);
    element.parentNode.removeChild(element);
  },

  update: function(element, html) {
    $(element).innerHTML = html.stripScripts();
    setTimeout(function() {html.evalScripts()}, 10);
  },

  replace: function(element, html) {
    element = $(element);
    if (element.outerHTML) {
      element.outerHTML = html.stripScripts();
    } else {
      var range = element.ownerDocument.createRange();
      range.selectNodeContents(element);
      element.parentNode.replaceChild(
        range.createContextualFragment(html.stripScripts()), element);
    }
    setTimeout(function() {html.evalScripts()}, 10);
  },

  getHeight: function(element) {
    element = $(element);
    return element.offsetHeight;
  },

  classNames: function(element) {
    return new Element.ClassNames(element);
  },

  hasClassName: function(element, className) {
    if (!(element = $(element))) return;
    return Element.classNames(element).include(className);
  },

  addClassName: function(element, className) {
    if (!(element = $(element))) return;
    return Element.classNames(element).add(className);
  },

  removeClassName: function(element, className) {
    if (!(element = $(element))) return;
    return Element.classNames(element).remove(className);
  },

  // removes whitespace-only text node children
  cleanWhitespace: function(element) {
    element = $(element);
    for (var i = 0; i < element.childNodes.length; i++) {
      var node = element.childNodes[i];
      if (node.nodeType == 3 && !/\S/.test(node.nodeValue))
        Element.remove(node);
    }
  },

  empty: function(element) {
    return $(element).innerHTML.match(/^\s*$/);
  },

  childOf: function(element, ancestor) {
    element = $(element), ancestor = $(ancestor);
    while (element = element.parentNode)
      if (element == ancestor) return true;
    return false;
  },

  scrollTo: function(element) {
    element = $(element);
    var x = element.x ? element.x : element.offsetLeft,
        y = element.y ? element.y : element.offsetTop;
    window.scrollTo(x, y);
  },

  getStyle: function(element, style) {
    element = $(element);
    var value = element.style[style.camelize()];
    if (!value) {
      if (document.defaultView && document.defaultView.getComputedStyle) {
        var css = document.defaultView.getComputedStyle(element, null);
        value = css ? css.getPropertyValue(style) : null;
      } else if (element.currentStyle) {
        value = element.currentStyle[style.camelize()];
      }
    }

    if (window.opera && ['left', 'top', 'right', 'bottom'].include(style))
      if (Element.getStyle(element, 'position') == 'static') value = 'auto';

    return value == 'auto' ? null : value;
  },

  setStyle: function(element, style) {
    element = $(element);
    for (var name in style)
      element.style[name.camelize()] = style[name];
  },

  getDimensions: function(element) {
    element = $(element);
    if (Element.getStyle(element, 'display') != 'none')
      return {width: element.offsetWidth, height: element.offsetHeight};

    // All *Width and *Height properties give 0 on elements with display none,
    // so enable the element temporarily
    var els = element.style;
    var originalVisibility = els.visibility;
    var originalPosition = els.position;
    els.visibility = 'hidden';
    els.position = 'absolute';
    els.display = '';
    var originalWidth = element.clientWidth;
    var originalHeight = element.clientHeight;
    els.display = 'none';
    els.position = originalPosition;
    els.visibility = originalVisibility;
    return {width: originalWidth, height: originalHeight};
  },

  makePositioned: function(element) {
    element = $(element);
    var pos = Element.getStyle(element, 'position');
    if (pos == 'static' || !pos) {
      element._madePositioned = true;
      element.style.position = 'relative';
      // Opera returns the offset relative to the positioning context, when an
      // element is position relative but top and left have not been defined
      if (window.opera) {
        element.style.top = 0;
        element.style.left = 0;
      }
    }
  },

  undoPositioned: function(element) {
    element = $(element);
    if (element._madePositioned) {
      element._madePositioned = undefined;
      element.style.position =
        element.style.top =
        element.style.left =
        element.style.bottom =
        element.style.right = '';
    }
  },

  makeClipping: function(element) {
    element = $(element);
    if (element._overflow) return;
    element._overflow = element.style.overflow;
    if ((Element.getStyle(element, 'overflow') || 'visible') != 'hidden')
      element.style.overflow = 'hidden';
  },

  undoClipping: function(element) {
    element = $(element);
    if (element._overflow) return;
    element.style.overflow = element._overflow;
    element._overflow = undefined;
  }
}

Object.extend(Element, Element.Methods);

var _nativeExtensions = false;

if(!HTMLElement && /Konqueror|Safari|KHTML/.test(navigator.userAgent)) {
  var HTMLElement = {}
  HTMLElement.prototype = document.createElement('div').__proto__;
}

Element.addMethods = function(methods) {
  Object.extend(Element.Methods, methods || {});

  if(typeof HTMLElement != 'undefined') {
    var methods = Element.Methods, cache = Element.extend.cache;
    for (property in methods) {
      var value = methods[property];
      if (typeof value == 'function')
        HTMLElement.prototype[property] = cache.findOrStore(value);
    }
    _nativeExtensions = true;
  }
}

Element.addMethods();

var Toggle = new Object();
Toggle.display = Element.toggle;

/*--------------------------------------------------------------------------*/

Abstract.Insertion = function(adjacency) {
  this.adjacency = adjacency;
}

Abstract.Insertion.prototype = {
  initialize: function(element, content) {
    this.element = $(element);
    this.content = content.stripScripts();

    if (this.adjacency && this.element.insertAdjacentHTML) {
      try {
        this.element.insertAdjacentHTML(this.adjacency, this.content);
      } catch (e) {
        var tagName = this.element.tagName.toLowerCase();
        if (tagName == 'tbody' || tagName == 'tr') {
          this.insertContent(this.contentFromAnonymousTable());
        } else {
          throw e;
        }
      }
    } else {
      this.range = this.element.ownerDocument.createRange();
      if (this.initializeRange) this.initializeRange();
      this.insertContent([this.range.createContextualFragment(this.content)]);
    }

    setTimeout(function() {content.evalScripts()}, 10);
  },

  contentFromAnonymousTable: function() {
    var div = document.createElement('div');
    div.innerHTML = '<table><tbody>' + this.content + '</tbody></table>';
    return $A(div.childNodes[0].childNodes[0].childNodes);
  }
}

var Insertion = new Object();

Insertion.Before = Class.create();
Insertion.Before.prototype = Object.extend(new Abstract.Insertion('beforeBegin'), {
  initializeRange: function() {
    this.range.setStartBefore(this.element);
  },

  insertContent: function(fragments) {
    fragments.each((function(fragment) {
      this.element.parentNode.insertBefore(fragment, this.element);
    }).bind(this));
  }
});

Insertion.Top = Class.create();
Insertion.Top.prototype = Object.extend(new Abstract.Insertion('afterBegin'), {
  initializeRange: function() {
    this.range.selectNodeContents(this.element);
    this.range.collapse(true);
  },

  insertContent: function(fragments) {
    fragments.reverse(false).each((function(fragment) {
      this.element.insertBefore(fragment, this.element.firstChild);
    }).bind(this));
  }
});

Insertion.Bottom = Class.create();
Insertion.Bottom.prototype = Object.extend(new Abstract.Insertion('beforeEnd'), {
  initializeRange: function() {
    this.range.selectNodeContents(this.element);
    this.range.collapse(this.element);
  },

  insertContent: function(fragments) {
    fragments.each((function(fragment) {
      this.element.appendChild(fragment);
    }).bind(this));
  }
});

Insertion.After = Class.create();
Insertion.After.prototype = Object.extend(new Abstract.Insertion('afterEnd'), {
  initializeRange: function() {
    this.range.setStartAfter(this.element);
  },

  insertContent: function(fragments) {
    fragments.each((function(fragment) {
      this.element.parentNode.insertBefore(fragment,
        this.element.nextSibling);
    }).bind(this));
  }
});

/*--------------------------------------------------------------------------*/

Element.ClassNames = Class.create();
Element.ClassNames.prototype = {
  initialize: function(element) {
    this.element = $(element);
  },

  _each: function(iterator) {
    this.element.className.split(/\s+/).select(function(name) {
      return name.length > 0;
    })._each(iterator);
  },

  set: function(className) {
    this.element.className = className;
  },

  add: function(classNameToAdd) {
    if (this.include(classNameToAdd)) return;
    this.set(this.toArray().concat(classNameToAdd).join(' '));
  },

  remove: function(classNameToRemove) {
    if (!this.include(classNameToRemove)) return;
    this.set(this.select(function(className) {
      return className != classNameToRemove;
    }).join(' '));
  },

  toString: function() {
    return this.toArray().join(' ');
  }
}

Object.extend(Element.ClassNames.prototype, Enumerable);
var Selector = Class.create();
Selector.prototype = {
  initialize: function(expression) {
    this.params = {classNames: []};
    this.expression = expression.toString().strip();
    this.parseExpression();
    this.compileMatcher();
  },

  parseExpression: function() {
    function abort(message) { throw 'Parse error in selector: ' + message; }

    if (this.expression == '')  abort('empty expression');

    var params = this.params, expr = this.expression, match, modifier, clause, rest;
    while (match = expr.match(/^(.*)\[([a-z0-9_:-]+?)(?:([~\|!]?=)(?:"([^"]*)"|([^\]\s]*)))?\]$/i)) { params.attributes = params.attributes || []; params.attributes.push({name: match[2], operator: match[3], value: match[4] || match[5] || ''}); expr = match[1];}
if (expr == '*') return this.params.wildcard = true; while (match = expr.match(/^([^a-z0-9_-])?([a-z0-9_-]+)(.*)/i)) { modifier = match[1], clause = match[2], rest = match[3]; switch (modifier) { case '#': params.id = clause; break; case '.': params.classNames.push(clause); break; case '':
case undefined: params.tagName = clause.toUpperCase(); break; default: abort(expr.inspect());}
expr = rest;}
if (expr.length > 0) abort(expr.inspect());}, buildMatchExpression: function() { var params = this.params, conditions = [], clause; if (params.wildcard)
conditions.push('true'); if (clause = params.id)
conditions.push('element.id == ' + clause.inspect()); if (clause = params.tagName)
conditions.push('element.tagName.toUpperCase() == ' + clause.inspect()); if ((clause = params.classNames).length > 0)
for (var i = 0; i < clause.length; i++)
conditions.push('Element.hasClassName(element, ' + clause[i].inspect() + ')'); if (clause = params.attributes) { clause.each(function(attribute) { var value = 'element.getAttribute(' + attribute.name.inspect() + ')'; var splitValueBy = function(delimiter) { return value + ' && ' + value + '.split(' + delimiter.inspect() + ')';}
switch (attribute.operator) { case '=': conditions.push(value + ' == ' + attribute.value.inspect()); break; case '~=': conditions.push(splitValueBy(' ') + '.include(' + attribute.value.inspect() + ')'); break; case '|=': conditions.push( splitValueBy('-') + '.first().toUpperCase() == ' + attribute.value.toUpperCase().inspect() ); break; case '!=': conditions.push(value + ' != ' + attribute.value.inspect()); break; case '':
case undefined: conditions.push(value + ' != null'); break; default: throw 'Unknown operator ' + attribute.operator + ' in selector';}
});}
return conditions.join(' && ');}, compileMatcher: function() { this.match = new Function('element', 'if (!element.tagName) return false; \
      return ' + this.buildMatchExpression());}, findElements: function(scope) { var element; if (element = $(this.params.id))
if (this.match(element))
if (!scope || Element.childOf(element, scope))
return [element]; scope = (scope || document).getElementsByTagName(this.params.tagName || '*'); var results = []; for (var i = 0; i < scope.length; i++)
if (this.match(element = scope[i]))
results.push(Element.extend(element)); return results;}, toString: function() { return this.expression;}
}
function $$() { return $A(arguments).map(function(expression) { return expression.strip().split(/\s+/).inject([null], function(results, expr) { var selector = new Selector(expr); return results.map(selector.findElements.bind(selector)).flatten();});}).flatten();}
var Field = { clear: function() { for (var i = 0; i < arguments.length; i++)
$(arguments[i]).value = '';}, focus: function(element) { $(element).focus();}, present: function() { for (var i = 0; i < arguments.length; i++)
if ($(arguments[i]).value == '') return false; return true;}, select: function(element) { $(element).select();}, activate: function(element) { element = $(element); element.focus(); if (element.select)
element.select();}
}
var Form = { serialize: function(form) { var elements = Form.getElements($(form)); var queryComponents = new Array(); for (var i = 0; i < elements.length; i++) { var queryComponent = Form.Element.serialize(elements[i]); if (queryComponent)
queryComponents.push(queryComponent);}
return queryComponents.join('&');}, getElements: function(form) { form = $(form); var elements = new Array(); for (var tagName in Form.Element.Serializers) { var tagElements = form.getElementsByTagName(tagName); for (var j = 0; j < tagElements.length; j++)
elements.push(tagElements[j]);}
return elements;}, getInputs: function(form, typeName, name) { form = $(form); var inputs = form.getElementsByTagName('input'); if (!typeName && !name)
return inputs; var matchingInputs = new Array(); for (var i = 0; i < inputs.length; i++) { var input = inputs[i]; if ((typeName && input.type != typeName) || (name && input.name != name))
continue; matchingInputs.push(input);}
return matchingInputs;}, disable: function(form) { var elements = Form.getElements(form); for (var i = 0; i < elements.length; i++) { var element = elements[i]; element.blur(); element.disabled = 'true';}
}, enable: function(form) { var elements = Form.getElements(form); for (var i = 0; i < elements.length; i++) { var element = elements[i]; element.disabled = '';}
}, findFirstElement: function(form) { return Form.getElements(form).find(function(element) { return element.type != 'hidden' && !element.disabled &&
['input', 'select', 'textarea'].include(element.tagName.toLowerCase());});}, focusFirstElement: function(form) { Field.activate(Form.findFirstElement(form));}, reset: function(form) { $(form).reset();}
}
Form.Element = { serialize: function(element) { element = $(element); var method = element.tagName.toLowerCase(); var parameter = Form.Element.Serializers[method](element); if (parameter) { var key = encodeURIComponent(parameter[0]); if (key.length == 0) return; if (parameter[1].constructor != Array)
parameter[1] = [parameter[1]]; return parameter[1].map(function(value) { return key + '=' + encodeURIComponent(value);}).join('&');}
}, getValue: function(element) { element = $(element); var method = element.tagName.toLowerCase(); var parameter = Form.Element.Serializers[method](element); if (parameter)
return parameter[1];}
}
Form.Element.Serializers = { input: function(element) { switch (element.type.toLowerCase()) { case 'submit':
case 'hidden':
case 'password':
case 'text':
return Form.Element.Serializers.textarea(element); case 'checkbox':
case 'radio':
return Form.Element.Serializers.inputSelector(element);}
return false;}, inputSelector: function(element) { if (element.checked)
return [element.name, element.value];}, textarea: function(element) { return [element.name, element.value];}, select: function(element) { return Form.Element.Serializers[element.type == 'select-one' ?
'selectOne' : 'selectMany'](element);}, selectOne: function(element) { var value = '', opt, index = element.selectedIndex; if (index >= 0) { opt = element.options[index]; value = opt.value || opt.text;}
return [element.name, value];}, selectMany: function(element) { var value = []; for (var i = 0; i < element.length; i++) { var opt = element.options[i]; if (opt.selected)
value.push(opt.value || opt.text);}
return [element.name, value];}
}
var $F = Form.Element.getValue; Abstract.TimedObserver = function() {}
Abstract.TimedObserver.prototype = { initialize: function(element, frequency, callback) { this.frequency = frequency; this.element = $(element); this.callback = callback; this.lastValue = this.getValue(); this.registerCallback();}, registerCallback: function() { setInterval(this.onTimerEvent.bind(this), this.frequency * 1000);}, onTimerEvent: function() { var value = this.getValue(); if (this.lastValue != value) { this.callback(this.element, value); this.lastValue = value;}
}
}
Form.Element.Observer = Class.create(); Form.Element.Observer.prototype = Object.extend(new Abstract.TimedObserver(), { getValue: function() { return Form.Element.getValue(this.element);}
}); Form.Observer = Class.create(); Form.Observer.prototype = Object.extend(new Abstract.TimedObserver(), { getValue: function() { return Form.serialize(this.element);}
}); Abstract.EventObserver = function() {}
Abstract.EventObserver.prototype = { initialize: function(element, callback) { this.element = $(element); this.callback = callback; this.lastValue = this.getValue(); if (this.element.tagName.toLowerCase() == 'form')
this.registerFormCallbacks(); else
this.registerCallback(this.element);}, onElementEvent: function() { var value = this.getValue(); if (this.lastValue != value) { this.callback(this.element, value); this.lastValue = value;}
}, registerFormCallbacks: function() { var elements = Form.getElements(this.element); for (var i = 0; i < elements.length; i++)
this.registerCallback(elements[i]);}, registerCallback: function(element) { if (element.type) { switch (element.type.toLowerCase()) { case 'checkbox':
case 'radio':
Event.observe(element, 'click', this.onElementEvent.bind(this)); break; case 'password':
case 'text':
case 'textarea':
case 'select-one':
case 'select-multiple':
Event.observe(element, 'change', this.onElementEvent.bind(this)); break;}
}
}
}
Form.Element.EventObserver = Class.create(); Form.Element.EventObserver.prototype = Object.extend(new Abstract.EventObserver(), { getValue: function() { return Form.Element.getValue(this.element);}
}); Form.EventObserver = Class.create(); Form.EventObserver.prototype = Object.extend(new Abstract.EventObserver(), { getValue: function() { return Form.serialize(this.element);}
}); if (!window.Event) { var Event = new Object();}
Object.extend(Event, { KEY_BACKSPACE: 8, KEY_TAB: 9, KEY_RETURN: 13, KEY_ESC: 27, KEY_LEFT: 37, KEY_UP: 38, KEY_RIGHT: 39, KEY_DOWN: 40, KEY_DELETE: 46, element: function(event) { return event.target || event.srcElement;}, isLeftClick: function(event) { return (((event.which) && (event.which == 1)) || ((event.button) && (event.button == 1)));}, pointerX: function(event) { return event.pageX || (event.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));}, pointerY: function(event) { return event.pageY || (event.clientY + (document.documentElement.scrollTop || document.body.scrollTop));}, stop: function(event) { if (event.preventDefault) { event.preventDefault(); event.stopPropagation();} else { event.returnValue = false; event.cancelBubble = true;}
}, findElement: function(event, tagName) { var element = Event.element(event); while (element.parentNode && (!element.tagName || (element.tagName.toUpperCase() != tagName.toUpperCase())))
element = element.parentNode; return element;}, observers: false, _observeAndCache: function(element, name, observer, useCapture) { if (!this.observers) this.observers = []; if (element.addEventListener) { this.observers.push([element, name, observer, useCapture]); element.addEventListener(name, observer, useCapture);} else if (element.attachEvent) { this.observers.push([element, name, observer, useCapture]); element.attachEvent('on' + name, observer);}
}, unloadCache: function() { if (!Event.observers) return; for (var i = 0; i < Event.observers.length; i++) { Event.stopObserving.apply(this, Event.observers[i]); Event.observers[i][0] = null;}
Event.observers = false;}, observe: function(element, name, observer, useCapture) { var element = $(element); useCapture = useCapture || false; if (name == 'keypress' &&
(navigator.appVersion.match(/Konqueror|Safari|KHTML/) || element.attachEvent))
name = 'keydown'; this._observeAndCache(element, name, observer, useCapture);}, stopObserving: function(element, name, observer, useCapture) { var element = $(element); useCapture = useCapture || false; if (name == 'keypress' &&
(navigator.appVersion.match(/Konqueror|Safari|KHTML/) || element.detachEvent))
name = 'keydown'; if (element.removeEventListener) { element.removeEventListener(name, observer, useCapture);} else if (element.detachEvent) { element.detachEvent('on' + name, observer);}
}
}); if (navigator.appVersion.match(/\bMSIE\b/))
Event.observe(window, 'unload', Event.unloadCache, false); var Position = { includeScrollOffsets: false, prepare: function() { this.deltaX = window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0; this.deltaY = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;}, realOffset: function(element) { var valueT = 0, valueL = 0; do { valueT += element.scrollTop || 0; valueL += element.scrollLeft || 0; element = element.parentNode;} while (element); return [valueL, valueT];}, cumulativeOffset: function(element) { var valueT = 0, valueL = 0; do { valueT += element.offsetTop || 0; valueL += element.offsetLeft || 0; element = element.offsetParent;} while (element); return [valueL, valueT];}, positionedOffset: function(element) { var valueT = 0, valueL = 0; do { valueT += element.offsetTop || 0; valueL += element.offsetLeft || 0; element = element.offsetParent; if (element) { p = Element.getStyle(element, 'position'); if (p == 'relative' || p == 'absolute') break;}
} while (element); return [valueL, valueT];}, offsetParent: function(element) { if (element.offsetParent) return element.offsetParent; if (element == document.body) return element; while ((element = element.parentNode) && element != document.body)
if (Element.getStyle(element, 'position') != 'static')
return element; return document.body;}, within: function(element, x, y) { if (this.includeScrollOffsets)
return this.withinIncludingScrolloffsets(element, x, y); this.xcomp = x; this.ycomp = y; this.offset = this.cumulativeOffset(element); return (y >= this.offset[1] &&
y < this.offset[1] + element.offsetHeight &&
x >= this.offset[0] &&
x < this.offset[0] + element.offsetWidth);}, withinIncludingScrolloffsets: function(element, x, y) { var offsetcache = this.realOffset(element); this.xcomp = x + offsetcache[0] - this.deltaX; this.ycomp = y + offsetcache[1] - this.deltaY; this.offset = this.cumulativeOffset(element); return (this.ycomp >= this.offset[1] &&
this.ycomp < this.offset[1] + element.offsetHeight &&
this.xcomp >= this.offset[0] &&
this.xcomp < this.offset[0] + element.offsetWidth);}, overlap: function(mode, element) { if (!mode) return 0; if (mode == 'vertical')
return ((this.offset[1] + element.offsetHeight) - this.ycomp) /
element.offsetHeight; if (mode == 'horizontal')
return ((this.offset[0] + element.offsetWidth) - this.xcomp) /
element.offsetWidth;}, clone: function(source, target) { source = $(source); target = $(target); target.style.position = 'absolute'; var offsets = this.cumulativeOffset(source); target.style.top = offsets[1] + 'px'; target.style.left = offsets[0] + 'px'; target.style.width = source.offsetWidth + 'px'; target.style.height = source.offsetHeight + 'px';}, page: function(forElement) { var valueT = 0, valueL = 0; var element = forElement; do { valueT += element.offsetTop || 0; valueL += element.offsetLeft || 0; if (element.offsetParent==document.body)
if (Element.getStyle(element,'position')=='absolute') break;} while (element = element.offsetParent); element = forElement; do { valueT -= element.scrollTop || 0; valueL -= element.scrollLeft || 0;} while (element = element.parentNode); return [valueL, valueT];}, clone: function(source, target) { var options = Object.extend({ setLeft: true, setTop: true, setWidth: true, setHeight: true, offsetTop: 0, offsetLeft: 0
}, arguments[2] || {})
source = $(source); var p = Position.page(source); target = $(target); var delta = [0, 0]; var parent = null; if (Element.getStyle(target,'position') == 'absolute') { parent = Position.offsetParent(target); delta = Position.page(parent);}
if (parent == document.body) { delta[0] -= document.body.offsetLeft; delta[1] -= document.body.offsetTop;}
if(options.setLeft) target.style.left = (p[0] - delta[0] + options.offsetLeft) + 'px'; if(options.setTop) target.style.top = (p[1] - delta[1] + options.offsetTop) + 'px'; if(options.setWidth) target.style.width = source.offsetWidth + 'px'; if(options.setHeight) target.style.height = source.offsetHeight + 'px';}, absolutize: function(element) { element = $(element); if (element.style.position == 'absolute') return; Position.prepare(); var offsets = Position.positionedOffset(element); var top = offsets[1]; var left = offsets[0]; var width = element.clientWidth; var height = element.clientHeight; element._originalLeft = left - parseFloat(element.style.left || 0); element._originalTop = top - parseFloat(element.style.top || 0); element._originalWidth = element.style.width; element._originalHeight = element.style.height; element.style.position = 'absolute'; element.style.top = top + 'px';; element.style.left = left + 'px';; element.style.width = width + 'px';; element.style.height = height + 'px';;}, relativize: function(element) { element = $(element); if (element.style.position == 'relative') return; Position.prepare(); element.style.position = 'relative'; var top = parseFloat(element.style.top || 0) - (element._originalTop || 0); var left = parseFloat(element.style.left || 0) - (element._originalLeft || 0); element.style.top = top + 'px'; element.style.left = left + 'px'; element.style.height = element._originalHeight; element.style.width = element._originalWidth;}
}
if (/Konqueror|Safari|KHTML/.test(navigator.userAgent)) { Position.cumulativeOffset = function(element) { var valueT = 0, valueL = 0; do { valueT += element.offsetTop || 0; valueL += element.offsetLeft || 0; if (element.offsetParent == document.body)
if (Element.getStyle(element, 'position') == 'absolute') break; element = element.offsetParent;} while (element); return [valueL, valueT];}
}





var Scriptaculous = {
  Version: '1.5.3',
  require: function(libraryName) {
    // inserting via DOM fails in Safari 2.0, so brute force approach
    document.write('<script type="text/javascript" src="'+libraryName+'"></script>');
  },
  load: function() {
    if((typeof Prototype=='undefined') ||
      parseFloat(Prototype.Version.split(".")[0] + "." +
                 Prototype.Version.split(".")[1]) < 1.4)
      throw("script.aculo.us requires the Prototype JavaScript framework >= 1.4.0");
    
    $A(document.getElementsByTagName("script")).findAll( function(s) {
      return (s.src && s.src.match(/scriptaculous\.js(\?.*)?$/))
    }).each( function(s) {
      var path = s.src.replace(/scriptaculous\.js(\?.*)?$/,'');
      var includes = s.src.match(/\?.*load=([a-z,]*)/);
      
    });
  }
}

Scriptaculous.load();






String.prototype.parseColor = function() {  
  var color = '#';  
  if(this.slice(0,4) == 'rgb(') {  
    var cols = this.slice(4,this.length-1).split(',');  
    var i=0; do { color += parseInt(cols[i]).toColorPart() } while (++i<3);  
  } else {  
    if(this.slice(0,1) == '#') {  
      if(this.length==4) for(var i=1;i<4;i++) color += (this.charAt(i) + this.charAt(i)).toLowerCase();  
      if(this.length==7) color = this.toLowerCase();  
    }  
  }  
  return(color.length==7 ? color : (arguments[0] || this));  
}

Element.collectTextNodes = function(element) {  
  return $A($(element).childNodes).collect( function(node) {
    return (node.nodeType==3 ? node.nodeValue : 
      (node.hasChildNodes() ? Element.collectTextNodes(node) : ''));
  }).flatten().join('');
}

Element.collectTextNodesIgnoreClass = function(element, className) {  
  return $A($(element).childNodes).collect( function(node) {
    return (node.nodeType==3 ? node.nodeValue : 
      ((node.hasChildNodes() && !Element.hasClassName(node,className)) ? 
        Element.collectTextNodesIgnoreClass(node, className) : ''));
  }).flatten().join('');
}

Element.setStyle = function(element, style) {
  element = $(element);
  for(k in style) element.style[k.camelize()] = style[k];
}

Element.setContentZoom = function(element, percent) {  
  Element.setStyle(element, {fontSize: (percent/100) + 'em'});   
  if(navigator.appVersion.indexOf('AppleWebKit')>0) window.scrollBy(0,0);  
}

Element.getOpacity = function(element){  
  var opacity;
  if (opacity = Element.getStyle(element, 'opacity'))  
    return parseFloat(opacity);  
  if (opacity = (Element.getStyle(element, 'filter') || '').match(/alpha\(opacity=(.*)\)/))  
    if(opacity[1]) return parseFloat(opacity[1]) / 100;  
  return 1.0;  
}

Element.setOpacity = function(element, value){  
  element= $(element);  
  if (value == 1){
    Element.setStyle(element, { opacity: 
      (/Gecko/.test(navigator.userAgent) && !/Konqueror|Safari|KHTML/.test(navigator.userAgent)) ? 
      0.999999 : null });
    if(/MSIE/.test(navigator.userAgent))  
      Element.setStyle(element, {filter: Element.getStyle(element,'filter').replace(/alpha\([^\)]*\)/gi,'')});  
  } else {  
    if(value < 0.00001) value = 0;  
    Element.setStyle(element, {opacity: value});
    if(/MSIE/.test(navigator.userAgent))  
     Element.setStyle(element, 
       { filter: Element.getStyle(element,'filter').replace(/alpha\([^\)]*\)/gi,'') +
                 'alpha(opacity='+value*100+')' });  
  }   
}  
 
Element.getInlineOpacity = function(element){  
  return $(element).style.opacity || '';
}  

Element.childrenWithClassName = function(element, className) {  
  return $A($(element).getElementsByTagName('*')).select(
    function(c) { return Element.hasClassName(c, className) });
}

Array.prototype.call = function() {
  var args = arguments;
  this.each(function(f){ f.apply(this, args) });
}

/*--------------------------------------------------------------------------*/

var Effect = {
  tagifyText: function(element) {
    var tagifyStyle = 'position:relative';
    if(/MSIE/.test(navigator.userAgent)) tagifyStyle += ';zoom:1';
    element = $(element);
    $A(element.childNodes).each( function(child) {
      if(child.nodeType==3) {
        child.nodeValue.toArray().each( function(character) {
          element.insertBefore(
            Builder.node('span',{style: tagifyStyle},
              character == ' ' ? String.fromCharCode(160) : character), 
              child);
        });
        Element.remove(child);
      }
    });
  },
  multiple: function(element, effect) {
    var elements;
    if(((typeof element == 'object') || 
        (typeof element == 'function')) && 
       (element.length))
      elements = element;
    else
      elements = $(element).childNodes;
      
    var options = Object.extend({
      speed: 0.1,
      delay: 0.0
    }, arguments[2] || {});
    var masterDelay = options.delay;

    $A(elements).each( function(element, index) {
      new effect(element, Object.extend(options, { delay: index * options.speed + masterDelay }));
    });
  },
  PAIRS: {
    'blind':  ['BlindDown','BlindUp'],
    'appear': ['Appear','Fade']
  },
  toggle: function(element, effect) {
    element = $(element);
    effect = (effect || 'appear').toLowerCase();
    var options = Object.extend({
      queue: { position:'end', scope:(element.id || 'global'), limit: 1 }
    }, arguments[2] || {});
    Effect[Element.visible(element) ? 
      Effect.PAIRS[effect][1] : Effect.PAIRS[effect][0]](element, options);
  }
};

var Effect2 = Effect; // deprecated

/* ------------- transitions ------------- */

Effect.Transitions = {}

Effect.Transitions.linear = function(pos) {
  return pos;
}
Effect.Transitions.sinoidal = function(pos) {
  return (-Math.cos(pos*Math.PI)/2) + 0.5;
}
Effect.Transitions.reverse  = function(pos) {
  return 1-pos;
}
Effect.Transitions.none = function(pos) {
  return 0;
}
Effect.Transitions.full = function(pos) {
  return 1;
}

/* ------------- core effects ------------- */

function show_hide_user_links(thediv)
{
	if(window.Effect){
		if(thediv.style.display == 'none')
		{Effect.Appear(thediv); return false;}
		else
		{Effect.Fade(thediv); return false;}
	}else{
		var replydisplay=thediv.style.display ? '' : 'none';
		thediv.style.display = replydisplay;					
	}
}

function bookmarksite(title, url)
{
	if (document.all)
		window.external.AddFavorite(url, title);
	else if (window.sidebar)
		window.sidebar.addPanel(title, url, "")
}

//** Tab Content script- © Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
//** Last updated: Nov 8th, 06

var enabletabpersistence=1 //enable tab persistence via session only cookies, so selected tab is remembered?

////NO NEED TO EDIT BELOW////////////////////////
var tabcontentIDs=new Object()

function expandcontent(linkobj){
var ulid=linkobj.parentNode.parentNode.id //id of DIV element
var ullist=document.getElementById(ulid).getElementsByTagName("span") //get list of SPANs corresponding to the tab contents
for (var i=0; i<ullist.length; i++){
ullist[i].className=""  //deselect all tabs
if (typeof tabcontentIDs[ulid][i]!="undefined") //if tab content within this array index exists (exception: More tabs than there are tab contents)
document.getElementById(tabcontentIDs[ulid][i]).style.display="none" //hide all tab contents
}
linkobj.parentNode.className="selected"  //highlight currently clicked on tab
document.getElementById(linkobj.getAttribute("rel")).style.display="block" //expand corresponding tab content
saveselectedtabcontentid(ulid, linkobj.getAttribute("rel"))
}

function expandtab(tabcontentid, tabnumber){ //interface for selecting a tab (plus expand corresponding content)
var thetab=document.getElementById(tabcontentid).getElementsByTagName("a")[tabnumber]
if (thetab.getAttribute("rel"))
expandcontent(thetab)
}

function savetabcontentids(ulid, relattribute){// save ids of tab content divs
if (typeof tabcontentIDs[ulid]=="undefined") //if this array doesn't exist yet
tabcontentIDs[ulid]=new Array()
tabcontentIDs[ulid][tabcontentIDs[ulid].length]=relattribute
}

function saveselectedtabcontentid(ulid, selectedtabid){ //set id of clicked on tab as selected tab id & enter into cookie
if (enabletabpersistence==1) //if persistence feature turned on
setCookie(ulid, selectedtabid)
}

function getullistlinkbyId(ulid, tabcontentid){ //returns a tab link based on the ID of the associated tab content
var ullist=document.getElementById(ulid).getElementsByTagName("li")
for (var i=0; i<ullist.length; i++){
if (ullist[i].getElementsByTagName("a")[0].getAttribute("rel")==tabcontentid){
return ullist[i].getElementsByTagName("a")[0]
break
}
}
}

function initializetabcontent(){
for (var i=0; i<arguments.length; i++){ //loop through passed UL ids
if (enabletabpersistence==0 && getCookie(arguments[i])!="") //clean up cookie if persist=off
setCookie(arguments[i], "")
var clickedontab=getCookie(arguments[i]) //retrieve ID of last clicked on tab from cookie, if any
var ulobj=document.getElementById(arguments[i])
var ulist=ulobj.getElementsByTagName("span") //array containing the LI elements within UL
for (var x=0; x<ulist.length; x++){ //loop through each LI element
var ulistlink=ulist[x].getElementsByTagName("a")[0]
if (ulistlink.getAttribute("rel")){
savetabcontentids(arguments[i], ulistlink.getAttribute("rel")) //save id of each tab content as loop runs
ulistlink.onclick=function(){
expandcontent(this)
return false
}
if (ulist[x].className=="selected" && clickedontab=="") //if a tab is set to be selected by default
expandcontent(ulistlink) //auto load currenly selected tab content
}
} //end inner for loop
if (clickedontab!=""){ //if a tab has been previously clicked on per the cookie value
var culistlink=getullistlinkbyId(arguments[i], clickedontab)
if (typeof culistlink!="undefined") //if match found between tabcontent id and rel attribute value
expandcontent(culistlink) //auto load currenly selected tab content
else //else if no match found between tabcontent id and rel attribute value (cookie mis-association)
expandcontent(ulist[0].getElementsByTagName("a")[0]) //just auto load first tab instead
}
} //end outer for loop
}


function getCookie(Name){ 
var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
if (document.cookie.match(re)) //if cookie found
return document.cookie.match(re)[0].split("=")[1] //return its value
return ""
}

function setCookie(name, value){
document.cookie = name+"="+value //cookie value is domain wide (path=/)
}

Effect.ScopedQueue = Class.create();
Object.extend(Object.extend(Effect.ScopedQueue.prototype, Enumerable), {
  initialize: function() {
    this.effects  = [];
    this.interval = null;
  },
  _each: function(iterator) {
    this.effects._each(iterator);
  },
  add: function(effect) {
    var timestamp = new Date().getTime();
    
    var position = (typeof effect.options.queue == 'string') ? 
      effect.options.queue : effect.options.queue.position;
    
    switch(position) {
      case 'front':
        // move unstarted effects after this effect  
        this.effects.findAll(function(e){ return e.state=='idle' }).each( function(e) {
            e.startOn  += effect.finishOn;
            e.finishOn += effect.finishOn;
          });
        break;
      case 'end':
        // start effect after last queued effect has finished
        timestamp = this.effects.pluck('finishOn').max() || timestamp;
        break;
    }
    
    effect.startOn  += timestamp;
    effect.finishOn += timestamp;

    if(!effect.options.queue.limit || (this.effects.length < effect.options.queue.limit))
      this.effects.push(effect);
    
    if(!this.interval) 
      this.interval = setInterval(this.loop.bind(this), 40);
  },
  remove: function(effect) {
    this.effects = this.effects.reject(function(e) { return e==effect });
    if(this.effects.length == 0) {
      clearInterval(this.interval);
      this.interval = null;
    }
  },
  loop: function() {
    var timePos = new Date().getTime();
    this.effects.invoke('loop', timePos);
  }
});

Effect.Queues = {
  instances: $H(),
  get: function(queueName) {
    if(typeof queueName != 'string') return queueName;
    
    if(!this.instances[queueName])
      this.instances[queueName] = new Effect.ScopedQueue();
      
    return this.instances[queueName];
  }
}
Effect.Queue = Effect.Queues.get('global');

Effect.DefaultOptions = {
  transition: Effect.Transitions.sinoidal,
  duration:   1.0,   // seconds
  fps:        25.0,  // max. 25fps due to Effect.Queue implementation
  sync:       false, // true for combining
  from:       0.0,
  to:         1.0,
  delay:      0.0,
  queue:      'parallel'
}

Effect.Base = function() {};
Effect.Base.prototype = {
  position: null,
  start: function(options) {
    this.options      = Object.extend(Object.extend({},Effect.DefaultOptions), options || {});
    this.currentFrame = 0;
    this.state        = 'idle';
    this.startOn      = this.options.delay*1000;
    this.finishOn     = this.startOn + (this.options.duration*1000);
    this.event('beforeStart');
    if(!this.options.sync)
      Effect.Queues.get(typeof this.options.queue == 'string' ? 
        'global' : this.options.queue.scope).add(this);
  },
  loop: function(timePos) {
    if(timePos >= this.startOn) {
      if(timePos >= this.finishOn) {
        this.render(1.0);
        this.cancel();
        this.event('beforeFinish');
        if(this.finish) this.finish(); 
        this.event('afterFinish');
        return;  
      }
      var pos   = (timePos - this.startOn) / (this.finishOn - this.startOn);
      var frame = Math.round(pos * this.options.fps * this.options.duration);
      if(frame > this.currentFrame) {
        this.render(pos);
        this.currentFrame = frame;
      }
    }
  },
  render: function(pos) {
    if(this.state == 'idle') {
      this.state = 'running';
      this.event('beforeSetup');
      if(this.setup) this.setup();
      this.event('afterSetup');
    }
    if(this.state == 'running') {
      if(this.options.transition) pos = this.options.transition(pos);
      pos *= (this.options.to-this.options.from);
      pos += this.options.from;
      this.position = pos;
      this.event('beforeUpdate');
      if(this.update) this.update(pos);
      this.event('afterUpdate');
    }
  },
  cancel: function() {
    if(!this.options.sync)
      Effect.Queues.get(typeof this.options.queue == 'string' ? 
        'global' : this.options.queue.scope).remove(this);
    this.state = 'finished';
  },
  event: function(eventName) {
    if(this.options[eventName + 'Internal']) this.options[eventName + 'Internal'](this);
    if(this.options[eventName]) this.options[eventName](this);
  },
  inspect: function() {
    return '#<Effect:' + $H(this).inspect() + ',options:' + $H(this.options).inspect() + '>';
  }
}

Effect.Opacity = Class.create();
Object.extend(Object.extend(Effect.Opacity.prototype, Effect.Base.prototype), {
  initialize: function(element) {
    this.element = $(element);
    // make this work on IE on elements without 'layout'
    if(/MSIE/.test(navigator.userAgent) && (!this.element.hasLayout))
      Element.setStyle(this.element, {zoom: 1});
    var options = Object.extend({
      from: Element.getOpacity(this.element) || 0.0,
      to:   1.0
    }, arguments[1] || {});
    this.start(options);
  },
  update: function(position) {
    Element.setOpacity(this.element, position);
  }
});

Effect.Scale = Class.create();
Object.extend(Object.extend(Effect.Scale.prototype, Effect.Base.prototype), {
  initialize: function(element, percent) {
    this.element = $(element)
    var options = Object.extend({
      scaleX: true,
      scaleY: true,
      scaleContent: true,
      scaleFromCenter: false,
      scaleMode: 'box',        // 'box' or 'contents' or {} with provided values
      scaleFrom: 100.0,
      scaleTo:   percent
    }, arguments[2] || {});
    this.start(options);
  },
  setup: function() {
    this.restoreAfterFinish = this.options.restoreAfterFinish || false;
    this.elementPositioning = Element.getStyle(this.element,'position');
    
    this.originalStyle = {};
    ['top','left','width','height','fontSize'].each( function(k) {
      this.originalStyle[k] = this.element.style[k];
    }.bind(this));
      
    this.originalTop  = this.element.offsetTop;
    this.originalLeft = this.element.offsetLeft;
    
    var fontSize = Element.getStyle(this.element,'font-size') || '100%';
    ['em','px','%'].each( function(fontSizeType) {
      if(fontSize.indexOf(fontSizeType)>0) {
        this.fontSize     = parseFloat(fontSize);
        this.fontSizeType = fontSizeType;
      }
    }.bind(this));
    
    this.factor = (this.options.scaleTo - this.options.scaleFrom)/100;
    
    this.dims = null;
    if(this.options.scaleMode=='box')
      this.dims = [this.element.offsetHeight, this.element.offsetWidth];
    if(/^content/.test(this.options.scaleMode))
      this.dims = [this.element.scrollHeight, this.element.scrollWidth];
    if(!this.dims)
      this.dims = [this.options.scaleMode.originalHeight,
                   this.options.scaleMode.originalWidth];
  },
  update: function(position) {
    var currentScale = (this.options.scaleFrom/100.0) + (this.factor * position);
    if(this.options.scaleContent && this.fontSize)
      Element.setStyle(this.element, {fontSize: this.fontSize * currentScale + this.fontSizeType });
    this.setDimensions(this.dims[0] * currentScale, this.dims[1] * currentScale);
  },
  finish: function(position) {
    if (this.restoreAfterFinish) Element.setStyle(this.element, this.originalStyle);
  },
  setDimensions: function(height, width) {
    var d = {};
    if(this.options.scaleX) d.width = width + 'px';
    if(this.options.scaleY) d.height = height + 'px';
    if(this.options.scaleFromCenter) {
      var topd  = (height - this.dims[0])/2;
      var leftd = (width  - this.dims[1])/2;
      if(this.elementPositioning == 'absolute') {
        if(this.options.scaleY) d.top = this.originalTop-topd + 'px';
        if(this.options.scaleX) d.left = this.originalLeft-leftd + 'px';
      } else {
        if(this.options.scaleY) d.top = -topd + 'px';
        if(this.options.scaleX) d.left = -leftd + 'px';
      }
    }
    Element.setStyle(this.element, d);
  }
});

/* ------------- combination effects ------------- */

Effect.Fade = function(element) {
  var oldOpacity = Element.getInlineOpacity(element);
  var options = Object.extend({
  from: Element.getOpacity(element) || 1.0,
  to:   0.0,
  afterFinishInternal: function(effect) { with(Element) { 
    if(effect.options.to!=0) return;
    hide(effect.element);
    setStyle(effect.element, {opacity: oldOpacity}); }}
  }, arguments[1] || {});
  return new Effect.Opacity(element,options);
}

Effect.Appear = function(element) {
  var options = Object.extend({
  from: (Element.getStyle(element, 'display') == 'none' ? 0.0 : Element.getOpacity(element) || 0.0),
  to:   1.0,
  beforeSetup: function(effect) { with(Element) {
    setOpacity(effect.element, effect.options.from);
    show(effect.element); }}
  }, arguments[1] || {});
  return new Effect.Opacity(element,options);
}

Effect.BlindUp = function(element) {
  element = $(element);
  Element.makeClipping(element);
  return new Effect.Scale(element, 0, 
    Object.extend({ scaleContent: false, 
      scaleX: false, 
      restoreAfterFinish: true,
      afterFinishInternal: function(effect) { with(Element) {
        [hide, undoClipping].call(effect.element); }} 
    }, arguments[1] || {})
  );
}

Effect.BlindDown = function(element) {
  element = $(element);
  var elementDimensions = Element.getDimensions(element);
  return new Effect.Scale(element, 100, 
    Object.extend({ scaleContent: false, 
      scaleX: false,
      scaleFrom: 0,
      scaleMode: {originalHeight: elementDimensions.height, originalWidth: elementDimensions.width},
      restoreAfterFinish: true,
      afterSetup: function(effect) { with(Element) {
        makeClipping(effect.element);
        setStyle(effect.element, {height: '0px'});
        show(effect.element); 
      }},  
      afterFinishInternal: function(effect) {
        Element.undoClipping(effect.element);
      }
    }, arguments[1] || {})
  );
}
