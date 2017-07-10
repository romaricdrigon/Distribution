import React, { Component } from 'react';


export default class GlossPart extends Component {

	render () {
		return (
			  <tr id="gloss-part-entry">
			    <td>{this.props.nom}</td>
			    <td>{this.props.role}</td>
			    <td>{this.props.titre}</td>
			    <td className="glyphicons">
			    	<a href="" onClick={this.props.fonction}>
			    		<span className="fa fa-share"></span>
			    	</a>
			    </td>
			  </tr>
		);
	};
}



