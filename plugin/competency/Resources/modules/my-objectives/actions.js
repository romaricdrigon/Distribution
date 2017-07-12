import {makeActionCreator} from '#/main/core/utilities/redux'
import {generateUrl} from '#/main/core/fos-js-router'
import {REQUEST_SEND} from '#/main/core/api/actions'
import {
  VIEW_MAIN,
  VIEW_COMPETENCY
} from './enums'

export const UPDATE_VIEW_MODE = 'UPDATE_VIEW_MODE'
export const COMPETENCY_DATA_RESET = 'COMPETENCY_DATA_RESET'
export const COMPETENCY_DATA_LOAD = 'COMPETENCY_DATA_LOAD'
export const COMPETENCY_DATA_UPDATE = 'COMPETENCY_DATA_UPDATE'

export const actions = {}

actions.updateViewMode = makeActionCreator(UPDATE_VIEW_MODE, 'mode')

actions.displayMainView = () => {
  return (dispatch) => {
    dispatch(actions.updateViewMode(VIEW_MAIN))
  }
}

actions.displayCompetencyView = (objectiveId, competencyId) => {
  return (dispatch) => {
    dispatch(actions.fetchCompetencyData(objectiveId, competencyId))
    dispatch(actions.updateViewMode(VIEW_COMPETENCY))
  }
}

actions.resetCompetencyData = makeActionCreator(COMPETENCY_DATA_RESET)
actions.loadCompetencyData = makeActionCreator(COMPETENCY_DATA_LOAD, 'data')
actions.updateCompetencyData = makeActionCreator(COMPETENCY_DATA_UPDATE, 'data')

actions.fetchCompetencyData = (objectiveId, competencyId) => {
  return (dispatch) => {
    dispatch({
      [REQUEST_SEND]: {
        url: generateUrl('hevinci_my_objectives_competency', {objective: objectiveId, competency: competencyId}),
        request: {method: 'GET'},
        success: (data, dispatch) => {
          dispatch(actions.loadCompetencyData(data))
        }
      }
    })
  }
}

actions.fetchLevelData = (competencyId, level) => {
  return (dispatch) => {
    dispatch({
      [REQUEST_SEND]: {
        url: generateUrl('hevinci_my_objectives_competency_level', {competency: competencyId, level: level}),
        request: {method: 'GET'},
        success: (data, dispatch) => {
          dispatch(actions.updateCompetencyData(data))
        }
      }
    })
  }
}