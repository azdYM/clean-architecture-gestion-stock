import React from 'react'

export function Icon ({name, size, className, onClick = null}) {
	const svgcClassName = `icon icon-${name}`
	const href = `assets/sprite.svg#${name}`

    const handleClick = (e) => {
        onClick !== null && onClick(e)
    }
    
	return (
        <gcrdt-icon onClick={handleClick} class={className}>
            <svg className={svgcClassName} width={`${size}%`} height={`${size}%`}>
                <use xlinkHref={href} />
            </svg>
        </gcrdt-icon>
	)
}
