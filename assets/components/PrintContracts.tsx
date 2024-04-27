import { forwardRef } from 'react'
import { ArticleData, ContractData, LabelForSignature } from "../api/credit"
import Markdown from 'markdown-to-jsx'

type ContractToPrintProps = {
  contracts?: ContractData[]
}
  
  
export const ContractsToPrint = forwardRef<HTMLDivElement, ContractToPrintProps>(function({contracts}, ref) {
	if (contracts === undefined || contracts.length === 0) 
		return <div>No doc to print</div>

	return (
		<div ref={ref}>
			{contracts.map((contract, i) => (
				<div key={i}>
					<ContractToPrint contract={contract} />
				</div>
			))}
		</div>
	)
}) 

const ContractToPrint = function({contract}: {contract: ContractData}) {
	return (
		<div>
			<header>Mon header</header>
			<Markdown options={{wrapper: 'section'}}>
				{contract.content}
			</Markdown>
			
			<section>
				{contract.articles.map((article, i) => <ArticleRenderer key={i} article={article} />)}
			</section>
			<footer>
				{contract.labelsForSignature.map(
					(signature, i) => <LabelForSignatureRenderer key={i} signature={signature} />
				)}
			</footer>
		</div>
	)
}

const ArticleRenderer = function({article}: {article: ArticleData}) {

	return (
		<article>
			<h1>{article.title}</h1>
			<Markdown>
				{article.description}
			</Markdown>
		</article>
	)
}

const LabelForSignatureRenderer = function({signature}: {signature: LabelForSignature}) {
	return (
		<div>
			<span>{signature.label}</span>
			<div></div>
		</div>
	)
}