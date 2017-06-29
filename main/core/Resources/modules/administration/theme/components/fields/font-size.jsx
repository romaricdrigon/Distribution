import React from 'react'
import {PropTypes as T} from 'prop-types'

import {trans} from '#/main/core/translation'
import {FormGroup} from '#/main/core/layout/form/components/form-group.jsx'

const FontSize = props =>
  <FormGroup
    controlId={props.controlId}
    label={trans('font_size', {}, 'theme')}
  >
    <div>
      <div className="btn-group">
        <button type="button" className="btn btn-default">
          small
        </button>

        <button type="button" className="btn btn-primary">
          normal
        </button>

        <button type="button" className="btn btn-default">
          large
        </button>

        <button type="button" className="btn btn-default">
          x-large
        </button>
      </div>
    </div>
  </FormGroup>

FontSize.propTypes = {
  controlId: T.string.isRequired
}

export {
  FontSize
}
