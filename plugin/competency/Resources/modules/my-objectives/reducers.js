import {makeReducer, combineReducers} from '#/main/core/utilities/redux'
import {VIEW_MAIN} from './enums'

import {
  UPDATE_VIEW_MODE,
  COMPETENCY_DATA_RESET,
  COMPETENCY_DATA_LOAD,
  COMPETENCY_DATA_UPDATE
} from './actions'

const initialState = {
  viewMode: VIEW_MAIN,
  objectives: [],
  objectivesCompetencies: {},
  competencies: {},
  competenciesProgress: {},
  competency: {
    data: {},
    objective: {},
    progress: {},
    nbLevels: 0,
    currentLevel: 0,
    challenge: {
      nbPassed: 0,
      nbToPass: 0
    }
  }
}

const viewReducers = {
  [UPDATE_VIEW_MODE]: (state, action) => {
    return action.mode
  }
}

const objectivesReducers = {
}

const competencyReducers = {
  [COMPETENCY_DATA_RESET]: () => initialState['competency'],
  [COMPETENCY_DATA_LOAD]: (state, action) => {
    return {
      data: action.data.competency,
      objective: action.data.objective,
      progress: action.data.progress,
      nbLevels: action.data.nbLevels,
      currentLevel: action.data.currentLevel,
      challenge: action.data.challenge
    }
  },
  [COMPETENCY_DATA_UPDATE]: (state, action) => {
    return {
      data: state.data,
      objective: state.objective,
      progress: state.progress,
      nbLevels: state.nbLevels,
      currentLevel: action.data.currentLevel,
      challenge: action.data.challenge
    }
  }
}

export const reducers = combineReducers({
  viewMode: makeReducer(initialState['viewMode'], viewReducers),
  objectives: makeReducer(initialState['objectives'], objectivesReducers),
  objectivesCompetencies: makeReducer(initialState['objectivesCompetencies'], objectivesReducers),
  competencies: makeReducer(initialState['competencies'], objectivesReducers),
  competency: makeReducer(initialState['competency'], competencyReducers)
})