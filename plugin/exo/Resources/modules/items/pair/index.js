import editor from './editor'
import {PairPaper} from './paper.jsx'
import {PairPlayer} from './player.jsx'
import {PairFeedback} from './feedback.jsx'

function expectAnswer() {
  return []
}

export default {
  type: 'application/x.pair+json',
  name: 'pair',
  paper: PairPaper,
  player: PairPlayer,
  feedback: PairFeedback,
  editor,
  expectAnswer
}
