import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import {Provider} from 'react-redux'
import {
  Table,
  TableRow,
  TableCell,
  TableTooltipCell,
  TableHeader,
  TableHeaderCell,
  TableSortingCell
} from './components/table/table'

// va chercher l'élément avec l'id lexicon
// instancie l'application react
//
const listResources = JSON.parse(document.getElementById('lexicon').dataset.resources)

class HandleEvent extends Component {

  constructor(props) {
    super(props);
  }

  render() {

    return (
        <div className="panel panel-default">
            {listResources.name}
        </div>
      );
  }

}

ReactDOM.render(
  <HandleEvent />,
  document.getElementById('lexicon')
)
