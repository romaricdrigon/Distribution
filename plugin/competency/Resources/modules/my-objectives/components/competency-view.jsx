import {connect} from 'react-redux'
import React, {Component} from 'react'
import {PropTypes as T} from 'prop-types'
import {trans} from '#/main/core/translation'
import {actions} from '../actions'

class CompetencyView extends Component {
  componentWillUnmount() {
    this.props.resetCompetency()
  }

  getSuccessRate() {
    return this.props.challenge.nbPassed > 0 && this.props.challenge.nbToPass > 0 ?
      Math.round((this.props.challenge.nbPassed / this.props.challenge.nbToPass) * 100) :
      0
  }

  render() {
    return (
      <div>
        <div className="my-objectives-tool-title">
          {this.props.objective.name}
        </div>
        <div className="my-objectives-tool-content">
          <div className="panel panel-default competency-panel">
            <div className="panel-heading">
              <h3 className="panel-title">
                {this.props.competency.name}
              </h3>
            </div>
            <div className="panel-body">
              <div className="level">
                {[...Array(this.props.currentLevel + 1)].map((x, index) =>
                  <i key={index} className="fa fa-star fa-2x" aria-hidden="true"></i>
                )}
                {this.props.nbLevels > 0 && [...Array(this.props.nbLevels - (this.props.currentLevel + 1))].map((x, index) =>
                  <i key={index} className="fa fa-star-o fa-2x" aria-hidden="true"></i>
                )}
              </div>
              <div className="current-level">
                <div className="change-level">
                  {this.props.currentLevel > 0 &&
                    <a
                      className="pointer-hand change-level-link"
                      onClick={() => this.props.getLevelData(this.props.competency.id, this.props.currentLevel - 1)}
                    >
                      <i className="fa fa-arrow-circle-left fa-5x" aria-hidden="true"></i>
                      {trans('objective.previous_level', {}, 'competency')}
                    </a>
                  }
                </div>
                <div className="current-level-content">
                  <div className="current-level-challenge">
                    <h3>{trans('objective.your_challenge', {}, 'competency')} :</h3>
                    {trans('objective.pass_n_resources', {n: this.props.challenge.nbToPass}, 'competency')}
                  </div>
                  {(!this.props.progress.level || (this.props.progress.level && this.props.progress.level.value < this.props.currentLevel)) &&
                    <div className={`c100 p${this.getSuccessRate()} small`}>
                      <span>{this.getSuccessRate()}%</span>
                      <div className="slice">
                        <div className="bar"></div>
                        <div className="fill"></div>
                      </div>
                    </div>
                  }
                  {this.props.progress.level && this.props.progress.level.value >= this.props.currentLevel &&
                    <div className="acquired-content">
                      <i className="fa fa-check-square-o fa-2x" aria-hidden="true"></i>
                      {trans('competency.acquired', {}, 'competency')}
                    </div>
                  }
                </div>
                <div className="change-level">
                  {this.props.currentLevel + 1 < this.props.nbLevels &&
                    <a
                      className="pointer-hand change-level-link"
                      onClick={() => this.props.getLevelData(this.props.competency.id, this.props.currentLevel + 1)}
                    >
                      {trans('objective.next_level', {}, 'competency')}
                      <i className="fa fa-arrow-circle-right fa-5x" aria-hidden="true"></i>
                    </a>
                  }
                </div>
              </div>
              <button className="btn btn-primary">
                {(this.props.progress.level && this.props.progress.level.value >= this.props.currentLevel) || this.getSuccessRate() === 100 ?
                  trans('objective.train', {}, 'competency') :
                  this.props.challenge.nbPassed === 0 ?
                    trans('objective.start', {}, 'competency') :
                    trans('objective.continue', {}, 'competency')
                }
              </button>
            </div>
          </div>
        </div>
      </div>
    )
  }
}

CompetencyView.propTypes = {
  competency: T.shape({
    id: T.number,
    name: T.string,
    description: T.string
  }).isRequired,
  objective: T.shape({
    id: T.number,
    name: T.string
  }).isRequired,
  progress: T.shape({
    id: T.number,
    percentage: T.number,
    level: T.shape({
      id: T.number,
      name: T.string,
      value: T.number
    })
  }).isRequired,
  nbLevels: T.number.isRequired,
  currentLevel: T.number.isRequired,
  challenge: T.shape({
    nbPassed: T.number,
    nbToPass: T.number
  }).isRequired,
  resetCompetency: T.func.isRequired,
  getLevelData: T.func.isRequired
}

function mapStateToProps(state) {
  return {
    competency: state.competency.data,
    objective: state.competency.objective,
    progress: state.competency.progress,
    nbLevels: state.competency.nbLevels,
    currentLevel: state.competency.currentLevel,
    challenge: state.competency.challenge
  }
}

function mapDispatchToProps(dispatch) {
  return {
    resetCompetency: () => {
      dispatch(actions.resetCompetencyData())
    },
    getLevelData: (competencyId, level) => {
      dispatch(actions.fetchLevelData(competencyId, level))
    }
  }
}

const ConnectedCompetencyView = connect(mapStateToProps, mapDispatchToProps)(CompetencyView)

export {ConnectedCompetencyView as CompetencyView}