/*

Author: Greg Burghardt
greg [underscore] burghardt [at] yahoo [dot] com
Copyright 2007, Greg Burghardt

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

http://www.gnu.org/licenses/lgpl.txt

*/


/**
 * @package   stripes
 * @desc      Easily create zebra striped tables and lists.
 * @copyright (c) 2008 Greg Burghardt
 * @contact   Greg Burghardt: greg [underscore] burghardt [at] yahoo [dot] com
 * @link      http://fundamentaldisaster.blogspot.com/2008/10/javascript-zebra-stripes-alternate.html
 * @property  string  stripeRowEven       Class name for even rows
 * @property  string  stripeRowOdd        Class name for odd rows
 * @property  string  stripeParentClass   Class name for striped tables or lists
 */

 window.onload = function() {
  stripes.execute();
};

window.stripes = {
  
  stripeRowEven : "rowA",
  stripeRowOdd : "rowB",
  stripeParentClass : "stripes",
  
  /**
   * @package stripes
   * @method  create
   * @desc    Creates zebra stripes on table and list elements.
   * @param   mixed   required  HTML Id or node reference
   * @return  void
   */
  create : function(el) {
    if (typeof(el) == "string") {
      el = document.getElementById(el);
    }
    if (!el || !el.nodeName) {
      return;
    }
    switch ( el.nodeName.toLowerCase() ) {
      case "table":
      case "tbody":
        this.createTable(el);
        break;
      case "ul":
      case "ol":
        this.createList(el);
        break;
      case "dl":
        this.createDL(el);
        break;
    }
  },
  
  /**
   * @package stripes
   * @method  createDL
   * @desc    Creates zebra stripes on definition lists.
   * @param   mixed   required  HTML Id or node reference
   * @return  void
   */
  createDL : function(dl) {
    var i = 0;
    var end = dl.childNodes.length;
    var termCount = 0;
    var child;
    var currentClass = this.stripeRowEven;
    
    while (i < end) {
      child = dl.childNodes[i];
      if (child.nodeName == "DT") {
        currentClass = (termCount % 2 == 0) ? this.stripeRowEven : this.stripeRowOdd;
        termCount++;
        child.className = currentClass;
      } else if (child.nodeName == "DD") {
        child.className = currentClass;
      }
      i++;
    }
  },
  
  /**
   * @package stripes
   * @method  createList
   * @desc    Creates zebra stripes on <UL> and <OL> lists.
   * @param   mixed   required  HTML Id or node reference
   * @return  void
   */
  createList : function(list) {
    var i = 0;
    var itemCount = 0;
    var end = list.childNodes.length;
    
    while (i < end) {
      if (list.childNodes[i].nodeName == "LI") {
        list.childNodes[i].className = (itemCount % 2 == 0) ? this.stripeRowEven : this.stripeRowOdd;
        itemCount++;
      }
      i++;
    }
  },
  
  /**
   * @package stripes
   * @method  createTable
   * @desc    Creates zebra stripes on tables.
   * @param   mixed   required  HTML Id or node reference
   * @return  void
   */
  createTable : function(table) {
    var row = 0;
    var rowEnd = table.rows.length;
    var parentNodeName = ""
    
    while (row < rowEnd) {
      parentNodeName = table.rows[row].parentNode.nodeName;
      if (parentNodeName != "THEAD" && parentNodeName != "TFOOT") {
        table.rows[row].className = (row % 2 == 0) ? this.stripeRowEven : this.stripeRowOdd;
      }
      row++;
    }
    table = null;
  },
  
  /**
   * @package stripes
   * @method  execute
   * @desc    Calls the create() function. Usefull of onload events.
   * @param   mixed   required  HTML Id or node reference to root element
   * @return  void
   */
  execute : function(root) {
    // Get root by Id
    if ( typeof(root) == "string" ) {
      root = document.getElementById(root);
    }
    
    // Default root is document element
    if ( !root || typeof(root) != "object" ) {
      root = document;
    }
    
    var nodeNames = ["table", "ul", "ol", "dl"];
    var name = 0;
    var nodeNamesEnd = nodeNames.length;
    var nodeList;
    var node = 0;
    var nodesEnd = 0;
    
    while (name < nodeNamesEnd) {
      nodeList = root.getElementsByTagName( nodeNames[name] );
      node = 0;
      nodeListEnd = nodeList.length;
      
      while (node < nodeListEnd) {
        if (nodeList[node].className && nodeList[node].className == this.stripeParentClass) {
          this.create( nodeList[node] );
        }
        node++;
      }
      
      name++;
    }
    
    root = null;
    nodeList = null;
  }
  
};