import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'
import classes from 'classnames'

import {DataList} from '#/main/core/layout/list/components/data-list.jsx'
import {tex, transChoice, t} from '#/main/core/translation'
import {makeModal} from '#/main/core/layout/modal'

import { Page, PageHeader, PageContent} from '#/main/core/layout/page/components/page.jsx'
import { PageActions, PageAction } from '#/main/core/layout/page/components/page-actions.jsx'
import { Pagination } from '#/main/core/layout/pagination/components/pagination.jsx'

import {select} from './../selectors'

import {actions as modalActions} from '#/main/core/layout/modal/actions'
import {actions as paginationActions} from '#/main/core/layout/pagination/actions'
import {actions as listActions} from '#/main/core/layout/list/actions'
import {actions} from '../actions/search'

import {select as paginationSelect} from '#/main/core/layout/pagination/selectors'
import {select as listSelect} from '#/main/core/layout/list/selectors'

import VisibleQuestions from './../containers/visible-questions.jsx'

import {MODAL_SEARCH} from './modal/search.jsx'
import {MODAL_ADD_ITEM} from './../../quiz/editor/components/add-item-modal.jsx'

// TODO : do not load add item modal from editor
// TODO : finish to refactor modals for using the ones embed in <Page> component

const Bank = props =>
  <Page
    modal={props.modal}
    fadeModal={props.fadeModal}
    hideModal={props.hideModal}
  >
    <PageHeader
      title={tex('questions_bank')}
    />

    {props.modal.type &&
      props.createModal(
        props.modal.type,
        props.modal.props,
        props.modal.fading
      )
    }

    <PageContent>
      <DataList
          data={props.questions}
          totalResults={props.totalResults}

          definition={[
            {name: 'content', type: 'string', label: t('name')},
          ]}

          filters={{
              current: props.filters,
              addFilter: props.addListFilter,
              removeFilter: props.removeListFilter
            }}

          sorting={{
              current: props.sortBy,
              updateSort: props.updateSort
            }}

          pagination={Object.assign({}, props.pagination, {
              handlePageChange: props.handlePageChange,
              handlePageSizeUpdate: props.handlePageSizeUpdate
            })}

      />
    </PageContent>
  </Page>

Bank.propTypes = {
  totalResults: T.number.isRequired,
  searchFilters: T.object.isRequired,
  activeFilters: T.number.isRequired,
  modal: T.shape({
    type: T.string,
    fading: T.bool.isRequired,
    props: T.object.isRequired
  }),
  pages: T.number.isRequired,
  pagination: T.shape({
    current: T.number.isRequired,
    pageSize: T.number.isRequired
  }),
  createModal: T.func.isRequired,
  fadeModal: T.func.isRequired,
  hideModal: T.func.isRequired,
  openSearchModal: T.func.isRequired,
  openAddModal: T.func.isRequired,
  handlePageChange: T.func.isRequired,
  handlePagePrevious: T.func.isRequired,
  handlePageNext: T.func.isRequired,
  handlePageSizeUpdate: T.func.isRequired
}

function mapStateToProps(state) {
  return {
    questions: state.questions.data,
    /*searchFilters: select.filters(state),
    activeFilters: select.countFilters(state),*/
    // filters: listSelect.filters(state),
    modal: select.modal(state),
    totalResults: state.questions.totalResults,
    // pagination: paginationSelect.getPagination(state),
    // pages: paginationSelect.countPages(state)

    selected: listSelect.selected(state),
    pagination: {
      pageSize: paginationSelect.pageSize(state),
      current:  paginationSelect.current(state)
    },
    filters: listSelect.filters(state),
    sortBy: listSelect.sortBy(state)
  }
}

function mapDispatchToProps(dispatch) {
  return {
    createModal: (type, props, fading) => makeModal(type, props, fading, dispatch),
    fadeModal() {
      dispatch(modalActions.fadeModal())
    },
    hideModal() {
      dispatch(modalActions.hideModal())
    },
    /*openSearchModal(searchFilters) {
      dispatch(modalActions.showModal(MODAL_SEARCH, {
        title: tex('search'),
        filters: searchFilters,
        handleSearch: (searchFilters) => dispatch(searchActions.search(searchFilters)),
        clearFilters: () => dispatch(searchActions.clearFilters()),
        fadeModal: () => dispatch(modalActions.fadeModal())
      }))
    },**/
    openAddModal() {
      dispatch(modalActions.showModal(MODAL_ADD_ITEM, {
        title: tex('add_question_from_new'),
        handleSelect: () => dispatch(modalActions.fadeModal())
      }))
    },
    // handlePagePrevious() {
    //   dispatch(paginationActions.previousPage())
    // },
    // handlePageNext() {
    //   dispatch(paginationActions.nextPage())
    // },
    // handlePageChange(page) {
    //   dispatch(paginationActions.changePage(page))
    // },
    // handlePageSizeUpdate(pageSize) {
    //   dispatch(paginationActions.updatePageSize(pageSize))
    // }

    // search
    addListFilter: (property, value) => {
      dispatch(listActions.addFilter(property, value))
      // grab updated workspace list
      dispatch(actions.fetchQuestions())
    },
    removeListFilter: (filter) => {
      dispatch(listActions.removeFilter(filter))
      // grab updated workspace list
      dispatch(actions.fetchQuestions())
    },

    // pagination
    handlePageSizeUpdate: (pageSize) => {
      dispatch(paginationActions.updatePageSize(pageSize))
      // grab updated workspace list
      dispatch(actions.fetchQuestions())
    },
    handlePageChange: (page) => {
      dispatch(paginationActions.changePage(page))
      // grab updated workspace list
      dispatch(actions.fetchQuestions())
    },

    // sorting
    updateSort: (property) => {
      dispatch(listActions.updateSort(property))
      // grab updated workspace list
      dispatch(actions.fetchQuestions())
    },

    // selection
    toggleSelect: (id) => dispatch(listActions.toggleSelect(id)),
    toggleSelectAll: (items) => dispatch(listActions.toggleSelectAll(items)),
  }
}

const ConnectedBank = connect(mapStateToProps, mapDispatchToProps)(Bank)

export {ConnectedBank as Bank}
