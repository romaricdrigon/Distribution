import React, { Component } from 'react';



export default class GlossPerso extends Component {

	render() {
    return (
  	  <tr className="gloss-pers-entry" id="{this.props.idGloss}">
          <td>{this.props.titre}</td>
          <td className="glyphicons">
            <ul className="pagination">
              <li className=""><a href="#" onClick={this.props.edit}><span className="fa fa-pencil"></span></a></li>
              <li className=""><a href="" onClick={this.props.share}><span className="fa fa-share"></span></a></li>
              <li className=""><a href="" onClick={this.props.del}><span className="fa fa-trash-o"></span></a></li>
            </ul>
          </td>
       </tr>
    );
	};
}