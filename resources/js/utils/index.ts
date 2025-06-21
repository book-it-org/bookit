/**
* A primeira letra e letras depois de 'espaço' se tornam maiúsculas.
* Substitui `-` por `espaço`.
*
* `(^|\s)` -> começo (`^`) ou (`|`) espaço (`\s`)
*
* `[a-z]` -> qualquer char contido entre `a` e `z`
*
*  `g` -> para todas as ocorrências
*/
export function formatarSearchParam(str: string): string {
    let result = str.replace(/-/g, ' ');
    result = result.replace(/(^|\s)[a-z]/g, (match) => match.toUpperCase());
    return result;
}
