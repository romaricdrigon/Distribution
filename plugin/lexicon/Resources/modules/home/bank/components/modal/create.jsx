import React, {Component, PropTypes as T} from 'react'
import classes from 'classnames'
import size from 'lodash/size'
import Modal from 'react-bootstrap/lib/Modal'

import {update} from './../../../utils/utils'
import {t, tex, trans} from './../../../utils/translate'
import {FormGroup} from './../../../components/form/form-group.jsx'

import {listItemMimeTypes, getDefinition} from './../../../items/item-types'
import {BaseModal} from './../../../modal/components/base.jsx'

export const MODAL_CREATE = 'MODAL_CREATE'

export class CreateModal extends Component {
  constructor(props) {
    super(props)

    this.state = {
      moreFilters: false,
      filters: Object.assign({
        title: '',
        model_only: false,
        types: [],
        self_only: false,
        creators: []
      }, props.filters)
    }
  }

  render() {
    return (
      <BaseModal {...this.props} className="create-modal">
        <Modal.Body>
          <FormGroup
            controlId="create-resource"
            label={tex('type')}
          >
            <input
              id="search-title"
              type="text"
              className="form-control"
              value={this.state.filters.title}
            />
          </FormGroup>
          
          <FormGroup
            controlId="title-resource"
            label={tex('Intitulé')}
          >
            <input
              id="create-title"
              type="text"
              className="form-control"
              value={this.state.filters.title}
            />
          </FormGroup>
          
          <FormGroup
            controlId="decription-resource"
            label={tex('Description')}
          >
            <input
              id="create-title"
              type="text"
              className="form-control"
              value={this.state.filters.title}
            />
          </FormGroup>

        </Modal.Body>

        <Modal.Footer>
          {0 < size(this.props.filters) &&
            <button className="btn btn-link link-danger pull-left" onClick={this.props.clearFilters}>
              <span className="fa fa-fw fa-ban"></span>
              {tex('filters_reset')}
            </button>
          }

          <button className="btn btn-default" onClick={this.props.fadeModal}>
            {t('cancel')}
          </button>
          <button className="btn btn-primary" onClick={() => this.props.handleSearch(this.state.filters)}>
            {t('Créer')}
          </button>
        </Modal.Footer>
      </BaseModal>
    )
  }
}

CreateModal.propTypes = {
  filters: T.shape({
    title: T.string,
    model_only: T.bool,
    types: T.arrayOf(T.string),
    self_only: T.bool,
    creators: T.array
  }).isRequired,
  fadeModal: T.func.isRequired,
  handleSearch: T.func.isRequired
}
