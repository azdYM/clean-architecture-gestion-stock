import { useState, useEffect, useContext } from 'react'
import { $ } from './dom'

export function useDisplayPopUp(elementName: string, callback?: () => void)
{
    const [ displayed, setDiplayed ] = useState(false)
    const { observe, disconnect } = useMutationObserver()
    
    useEffect(() => {
        const element = $(elementName)
        if (element) observe(element, () => observerPopUp(), ['style'])

        return () => disconnect()
    }, [])

    useEffect(() => {
        const targetElement = $(elementName) as HTMLElement

        const onClickDocument = () => {
            targetElement.style.display = 'none';
            setDiplayed(false)
        }

        // ce truc ne devrait pas être ici, sort le d'ici le plus vite possible
        const onClickTargetElement = (e: MouseEvent) => {
            const target = e.target as HTMLElement
            const targetIsLink = target.tagName === "A";
            const targetIsChildOfLink = target.closest(".link-menu") !== null

            // Je ne veux pas stoper la propagation si le target est un lient
            if (targetIsLink) {
                return
            } 

            // Je ne veux pas non plus stoper la propagation si le target est un 
            // enfant d'un lien
            if (targetIsChildOfLink) {
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
        callback !== undefined && callback()
    }

    return displayed;
}

export function useMutationObserver()
{
    let observer: MutationObserver|null = null;
    const observe = (targetElement: HTMLElement, callback: () => void, attributes: string[]) => 
    {
        const mutationCallback = (mutationsList: MutationRecord[], observer: MutationObserver) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'attributes' && attributes.includes(mutation.attributeName as string)) {
                    callback()
                }
            }
        }

        observer = new MutationObserver(mutationCallback)
        const config = {attributes: true, attributesFilter: attributes}

        observer.observe(targetElement, config)
    }

    return {observe, disconnect: () => observer?.disconnect()}
}

export const useCustomContext = <T>(context: React.Context<T>) => {
	return useContext(context)
}
