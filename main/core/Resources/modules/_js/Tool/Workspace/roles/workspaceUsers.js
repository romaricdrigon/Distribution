import table from '#/main/core/_old/table'
import $ from 'jquery'

/* global Translator */

let parameters = {}
parameters.route = {}
parameters.route.action = {}
parameters.route.normal = {'route': 'claro_workspace_registered_user_list', 'parameters': {'workspace': window.workspaceId, 'order': window.order }}
parameters.route.search = {'route': 'claro_workspace_registered_user_list_search', 'parameters': {'workspace': window.workspaceId, 'order': window.order }}
table.initialize(parameters)

$('.popover-block').popover()
$('.remove-role-button').on('click', function (event) {
  var target = $(event.currentTarget)
  var route = target.attr('href')
  $.ajax({
    url: route,
    type: 'DELETE',
    success: function () {
      if (target.parents('td').first().find('span').length === 1) {
        target.parents('tr').first().remove()
      } else {
        target.parent().remove()
      }
    },
    error: function (jqXHR) {
      window.Claroline.Modal.hide()
      window.Claroline.Modal.simpleContainer(
        Translator.trans('error', {}, 'platform'),
        jqXHR.responseJSON.message
      )
    }
  })
})