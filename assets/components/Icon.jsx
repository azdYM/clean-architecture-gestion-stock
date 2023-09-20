import React from 'react'

export function Icon ({name, size, className}) {
	const svgcClassName = `icon icon-${name}`
	const href = `assets/sprite.svg#${name}`
    
	return (
        <gcrdt-icon class={className}>
            <svg className={svgcClassName} width={`${size}%`} height={`${size}%`}>
                <use xlinkHref={href} />
            </svg>
        </gcrdt-icon>
	)
}
