import {useEffect} from 'react'

type ComponentRefs = {
    pageRef: React.RefObject<HTMLElement>,
    contentRef: React.RefObject<HTMLElement>,
    cardRef: React.RefObject<HTMLElement>
}
  
type ContentWraperWithCardProps = {
    componentsRef: ComponentRefs
    positionCard: ('left'|'right')
} & React.PropsWithChildren  

export const ContentWrapperWithCard = function({componentsRef, positionCard, children}: ContentWraperWithCardProps)
{
  useEffect(() => {
    const page = getElementFromRef(componentsRef.pageRef)
    const cardUser = getElementFromRef(componentsRef.cardRef)
    const gageContent = getElementFromRef(componentsRef.contentRef)
    const pageWidth = page.offsetWidth
    const cardUserWidth = cardUser.offsetWidth
   

    gageContent.style.width = `${pageWidth - (cardUserWidth + 80)}px`
    const contentWidth = gageContent.offsetWidth
    const ration = pageWidth - (cardUserWidth + contentWidth)
    
    cardUser.style['left'] = `${gageContent.getBoundingClientRect()[positionCard] + ration - 50}px`
    cardUser.style.top = `${page.getBoundingClientRect().top + 60}px`
  }, [])

  return (
    <>
      {children}
    </>
  )
}

const getElementFromRef = function(refObject: React.RefObject<HTMLElement|null>): HTMLElement 
{
  if (refObject.current === null) {
    throw new Error(`${refObject} ne peut pas être utilisé car il n'est pas associé à aucun HTMLElement`)
  }

  return refObject.current
} 
