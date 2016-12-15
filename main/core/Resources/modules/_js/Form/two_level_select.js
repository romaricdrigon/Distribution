import $ from 'jquery'
import 'jquery-option-tree'

$(document).ready(function () {
  var choices = window.choices
  var choicesTree = {}
  var preselectedValuePath = buildChoicesTree(choices, choicesTree, [], window.data)
  if (preselectedValuePath == null) {
    preselectedValuePath = [choices[0]['label']]
  }
  var inputName = $(`#${window.formId}`).attr('name')
  var choicesTreeOptions = {
    preselect: {},
    choose: ''
  }
  choicesTreeOptions.preselect[inputName] = preselectedValuePath
  $(`#${window.formId}`).optionTree(choicesTree, choicesTreeOptions)
})

function buildChoicesTree (choices, choicesTree, pathToNode, preselectedValue) {
  var preselectedValuePath = null
  for (var key in choices) {
    var label = choices[key].label
    label = label.substring(label.indexOf(':') + 1)
    if (!choices[key].choices) {
      choicesTree[label] = choices[key].value
      if (preselectedValue == choices[key].data) {
        preselectedValuePath = pathToNode.slice()
        preselectedValuePath.push(label)
      }
    } else {
      choicesTree[label] = {}
      var newPathToNode = pathToNode.slice()
      newPathToNode.push(key)
      var tempPreselectedPath = buildChoicesTree(choices[key].choices, choicesTree[label], newPathToNode, preselectedValue)
      if (tempPreselectedPath != null) {
        preselectedValuePath = tempPreselectedPath
      }
    }
  }

  return preselectedValuePath
}