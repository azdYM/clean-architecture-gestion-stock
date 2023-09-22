import { useState, useEffect, useContext } from 'react'
import { $, $$ } from '/functions/dom'

export function useDisplayPopUp(elementName, callback = null)
{
    const [ displayed, setDiplayed ] = useState(false)
    const { observe, disconnect } = useMutationObserver()
    
    useEffect(() => {
        const element = $(elementName, document)
        if (element) observe(element, () => observerPopUp())

        return () => disconnect()
    }, [])

    useEffect(() => {
        const targetElement = $(elementName, document)
        const onClickDocument = (e) => {
            targetElement.style.display = 'none';
            setDiplayed(false)
        }

        /**
         * 
         * @param {Event} e 
         */
        const onClickTargetElement = (e) => {
            const target = e.target

            const targetIsLink = () => target.tagName === "A";
            const targetIsChildOfLink = () => target.closest(".link-menu") !== null

            // Je ne veux pas stoper la propagation si le target est un lient
            if (targetIsLink()) {
                return
            } 

            // Je ne veux pas non plus stoper la propagation si le target est un 
            // enfant d'un lien
            if (targetIsChildOfLink()) {
                return
            }

            e.stopPropagation()
        }
        
        targetElement.addEventListener('click', onClickTargetElement)
        document.addEventListener('click', onClickDocument)

        return () => {
            document.removeEventListener('click', onClickDocument)
            targetElement.removeEventListener('click', onClickTargetElement)
        }
    }, [])

    function observerPopUp()
    {
        setDiplayed(true)
        callback !== null && callback()
    }

    return displayed;
}

export function useMutationObserver()
{
    let observer = null;
    const observe = (targetElement, callback) => {
        observer = new MutationObserver(function(mutationLists, observer) {
            for (const mutation of mutationLists) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    callback()
                }
            }
        })

        const config = {attributes: true, attributesFilter: ['style']}
        observer.observe(targetElement, config)
    }
    
    return {observe, disconnect: () => observer?.disconnect()}
}

export const useCustomContext = (context) => {
	return useContext(context)
}
