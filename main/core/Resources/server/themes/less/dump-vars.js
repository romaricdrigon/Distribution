module.exports = function (less) {
  function DumpVarsPlugin() {
    this._visitor = new less.visitors.Visitor(this)
  }

  DumpVarsPlugin.prototype = {
    isPreVisitor: true,
    run: function (root) {
      return this._visitor.visit(root);
    },
    visit: function (node) {
      console.log(node)
    }
    /*visitRule: function (ruleNode, visitArgs) {
     this._inRule = true;
     return ruleNode;
     },*/
    /*visitRuleOut: function (ruleNode, visitArgs) {
     this._inRule = false;
     },*/
    /*visitUrl: function (URLNode, visitArgs) {
     if (!this._inRule) {
     return URLNode;
     }
     if (URLNode.value && URLNode.value.value && URLNode.value.value.indexOf('#') === 0) {
     // Might be part of a VML url-node value like:
     // ``behavior:url(#default#VML);``
     return URLNode;
     }
     return new less.tree.Call("data-uri", [new ParamStringReplacementNode(URLNode.value)], URLNode.index || 0, URLNode.currentFileInfo);
     }*/
  }

  return DumpVarsPlugin
}