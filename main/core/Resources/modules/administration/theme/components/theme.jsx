import React from 'React'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import {withRouter} from 'react-router-dom'
import MenuItem from 'react-bootstrap/lib/MenuItem'

import {t, trans} from '#/main/core/translation'

import {actions as modalActions} from '#/main/core/layout/modal/actions'
import {actions} from '#/main/core/administration/theme/actions'

import {select} from '#/main/core/administration/theme/selectors'

import {
  PageContainer as Page,
  PageHeader,
  PageContent,
  PageGroupActions,
  PageActions,
  PageAction,
  MoreAction
} from '#/main/core/layout/page/index'

import {FormSections} from '#/main/core/layout/form/components/form-sections.jsx'
//import {FormGroup}    from '#/main/core/layout/form/components/form-group.jsx'
import {TextGroup}    from '#/main/core/layout/form/components/text-group.jsx'
import {FlagGroup}    from '#/main/core/layout/form/components/flag-group.jsx'

import {FontSize} from './fields/font-size.jsx'
import {FontSelector} from './fields/font-selector.jsx'
import {Size} from './fields/size.jsx'

const GeneralSection = props =>
  <div className="panel panel-default">
    <fieldset className="panel-body">
      <h2 className="sr-only">General properties</h2>

      <TextGroup
        controlId="theme-name"
        label={trans('theme_name', {}, 'theme')}
        value={props.theme.name}
        onChange={(value) => true}
      />

      <TextGroup
        controlId="theme-description"
        label={trans('theme_description', {}, 'theme')}
        value={props.theme.meta.description}
        long={true}
        onChange={(value) => true}
      />

      <FlagGroup
        controlId="theme-extend-default"
        label={trans('theme_extend_default', {}, 'theme')}
        active={props.theme.parameters.extendDefault}
        onChange={active => true}
        help={trans('theme_extend_default_help', {}, 'theme')}
      />

      <FlagGroup
        controlId="theme-enabled"
        label={trans('theme_enabled', {}, 'theme')}
        active={props.theme.meta.enabled}
        onChange={active => true}
        help={trans('theme_enabled_help', {}, 'theme')}
      />
    </fieldset>
  </div>

GeneralSection.propTypes = {
  theme: T.shape({
    name: T.string.isRequired,
    current: T.bool.isRequired,
    meta: T.shape({
      description: T.string,
      enabled: T.bool,
    }).isRequired,
    parameters: T.shape({
      extendDefault: T.bool
    }).isRequired
  }).isRequired
}

const TypoSection = props =>
  <fieldset>
    <h3>Headings</h3>
    <div className="sub-fields">
      <FontSelector
        controlId="headings-font"
        value="Century Gothic"
        onChange={(value) => true}
      />
      <FontSize controlId="headings-size" />
    </div>

    <h3>Content</h3>
    <div className="sub-fields">
      <FontSelector
        controlId="content-font"
        value="Arial"
        onChange={(value) => true}
      />
      <FontSize controlId="content-size" />
    </div>
  </fieldset>

TypoSection.propTypes = {

}

const ColorsSection = props =>
  <fieldset>
    Colors section
  </fieldset>

ColorsSection.propTypes = {

}

const SizingSection = props =>
  <fieldset>
    <Size
      controlId="app-width"
      value={1200}
      onChange={(value) => true}
    />
  </fieldset>

SizingSection.propTypes = {

}

const ExtraSection = props =>
  <fieldset>
    <FlagGroup
      controlId="enable-shadows"
      label={trans('enable_shadows', {}, 'theme')}
      active={true}
      onChange={active => true}
    />

    <FlagGroup
      controlId="enable-border-radius"
      label={trans('enable_border_radius', {}, 'theme')}
      active={true}
      onChange={active => true}
    />
  </fieldset>

ExtraSection.propTypes = {

}

const Theme = props =>
  <Page id="theme-form">
    <PageHeader
      title={t('themes_management')}
      subtitle={props.theme.name}
    >
      <PageActions>
        <PageGroupActions>
          <PageAction
            id="theme-add"
            title={trans('save_theme', {}, 'theme')}
            icon="fa fa-floppy-o"
            primary={true}
            action="#"
          />

          <PageAction
            id="themes-rebuild"
            title={trans('theme_rebuild', {}, 'theme')}
            icon="fa fa-refresh"
            action="#"
          />
        </PageGroupActions>

        <PageGroupActions>
          <PageAction
            id="themes-list"
            title={trans('themes_list', {}, 'theme')}
            icon="fa fa-list"
            action="#/"
          />

          <MoreAction id="resource-more">
            <MenuItem
              key="resource-group-type"
              header={true}
            >
              {t('more_actions')}
            </MenuItem>
            <MenuItem
              key="theme-copy"
              eventKey="theme-copy"
              href="#"
            >
              <span className="fa fa-fw fa-copy" />
              {trans('copy_theme', {}, 'theme')}
            </MenuItem>
            <MenuItem
              key="theme-export"
              eventKey="theme-export"
              href="#"
            >
              <span className="fa fa-fw fa-upload" />
              {trans('export', {}, 'theme')}
            </MenuItem>
            <MenuItem key="theme-delete-divider" divider={true} />
            <MenuItem
              key="theme-delete"
              eventKey="theme-delete"
              className="dropdown-link-danger"
              onClick={e => {
                {/*e.stopPropagation()
                props.showModal(MODAL_DELETE_CONFIRM, {
                  title: trans('delete', {}, 'theme'),
                  question: trans('delete_confirm_question', {}, 'theme'),
                  handleConfirm: () => true
                })*/}
              }}
            >
              <span className="fa fa-fw fa-trash" />
              {trans('delete', {}, 'theme')}
            </MenuItem>
          </MoreAction>
        </PageGroupActions>
      </PageActions>
    </PageHeader>

    <PageContent>
      <GeneralSection theme={props.theme} />

      <FormSections
        level={2}
        sections={[
          {
            id: 'theme-colors',
            label: 'Color schemes',
            icon: 'fa fa-fw fa-tint',
            children: <ColorsSection />
          }, {
            id: 'theme-typo',
            label: 'Typo & fonts',
            icon: 'fa fa-fw fa-font',
            children: <TypoSection />
          }, {
            id: 'theme-sizing',
            label: 'Sizing',
            icon: 'fa fa-fw fa-arrows-h',
            children: <SizingSection />
          }, {
            id: 'theme-extra',
            label: 'Extra features',
            icon: 'fa fa-fw fa-ellipsis-h',
            children: <ExtraSection />
          }
        ]}
      />
    </PageContent>
  </Page>

Theme.propTypes = {
  theme: T.shape({
    name: T.string.isRequired,
    current: T.bool.isRequired,
    meta: T.shape({
      description: T.string,
      enabled: T.bool,
    }).isRequired,
    parameters: T.shape({
      extendDefault: T.bool
    }).isRequired
  }).isRequired
}

function mapStateToProps(state, onwProps) {
  return {
    theme: select.themes(state).find(theme => onwProps.match.params.id === theme.id)
  }
}

function mapDispatchToProps(dispatch) {
  return {
    copyTheme: () => {
      dispatch(actions.copyTheme())
    },

    rebuildThemes: (themes) => {
      dispatch(actions.rebuildThemes(themes))
    },

    removeThemes: (themes) => {
      dispatch(actions.removeThemes(themes))
    },

    // modals
    showModal(modalType, modalProps) {
      dispatch(modalActions.showModal(modalType, modalProps))
    }
  }
}

const ConnectedTheme = withRouter(connect(mapStateToProps, mapDispatchToProps)(Theme))

export {ConnectedTheme as Theme}
