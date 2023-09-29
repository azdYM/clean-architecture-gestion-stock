
/**
 * 
 * @param {string} selector 
 * @param {HTMLElement} element 
 * @returns {HTMLElement}
 */
export function $(selector, element=null) {
  return element ? element.querySelector(selector) : document.querySelector(selector) || null
}

/**
 * 
 * @param {string} selector 
 * @param {HTMLElement} element 
 * @returns {Array}
 */
export function $$(selector, element=null) {
  const list = element ? element.querySelectorAll(selector) : document.querySelectorAll(selector) || null
  return Array.from(list)
}


/**
 * créer un element HTML
 * 
 * @param {string} tagName 
 * @param {object} attributes
 * @param  {...any} children 
 * @returns {HTMLElement}
 */
export function createElement(tagName, attributes={}, ...children) {
  if (typeof tagName == 'function') {
    return tagName(attributes)
  }
  
  const e = document.createElement(tagName)

  for (const k of Object.keys(attributes || {})) {
    if (typeof attributes[k] === 'function' && k.startsWith('on')) {
      e.addEventListener(k.substring(2), attributes[k])
    } else
      e.setAttribute(k, attributes[k])
  }

  //On met Tous les enfants au meme niveau (applatir le tableau children)
  children = children.reduce((acc, child) => {
    return Array.isArray(child) ? [...acc, ...child] : [...acc, child]
  }, []) 

  for (const child of children) {
    if (typeof child === 'number' || typeof child === 'string') {
      e.appendChild(document.createTextNode(child))
    } else if (child instanceof HTMLElement) {
      e.appendChild(child)
    } else {
      console.error("Impossible d'ajouter l'element", child, typeof child)
    }
  }

  return e
}