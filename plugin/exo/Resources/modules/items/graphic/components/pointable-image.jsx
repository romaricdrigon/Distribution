import React, {Component, PropTypes as T} from 'react'
import {Pointer} from './pointer.jsx'

export class PointableImage extends Component {
  constructor(props) {
    super(props)
    this.onResize = this.onResize.bind(this)
    this.state = {resizes: 0}
  }

  componentDidMount() {
    window.addEventListener('resize', this.onResize)
    // forces re-render based on computed relative coords of pointers
    // (possible only when img ref is available)
    this.onResize()
  }

  componentWillUnmount() {
    window.removeEventListener('resize', this.onResize)
  }

  onResize() {
    // "resizes" has no meaning here, we're just forcing a re-render of pointers
    this.setState({resizes: this.state.resizes + 1})
  }

  absToRel(length) {
    // img ref isn't available on first render (async)
    if (this.img) {
      return Math.round(length / (this.props.absWidth / this.img.width))
    }

    return 0
  }

  render() {
    return (
      <div className="pointable-img">
        <div style={{
          position: 'relative',
          cursor: this.props.onClick ? 'crosshair' : 'auto',
          userSelect: 'none'
        }}>
          <img
            ref={el => {
              this.img = el
              this.props.onRef(el)
            }}
            src={this.props.src}
            draggable={false}
            onDragStart={e => e.stopPropagation()}
            onClick={e => this.props.onClick && this.props.onClick(e)}
          />
          {this.props.pointers.map(pointer =>
            <Pointer
              key={`${pointer.absX}-${pointer.absY}`}
              x={this.absToRel(pointer.absX)}
              y={this.absToRel(pointer.absY)}
              type={pointer.type}
            />
          )}
        </div>
      </div>
    )
  }
}

PointableImage.propTypes = {
  src: T.string.isRequired,
  absWidth: T.number.isRequired,
  onRef: T.func.isRequired,
  onClick: T.func,
  pointers: T.arrayOf(T.shape({
    absX: T.number.isRequired,
    absY: T.number.isRequired,
    type: T.string.isRequired
  })).isRequired
}

PointableImage.defaultProps = {
  onRef: () => {}
}