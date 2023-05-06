<x-mail::message>
# New contact was shared with you

User {{ $fromUser }} shared contact {{ $sharedContact }} with you.

{{-- 

Las llaves dobles {{ }} se utilizan en Laravel para imprimir el contenido de una variable o expresión en una vista Blade.
Cuando se utilizan dentro de una etiqueta HTML, como en el caso del atributo :url del componente x-mail::button,
el contenido dentro de las llaves dobles se evalúa como una expresión PHP y se imprime como texto.

Sin embargo, en el caso de pasar una variable o expresión a un componente Blade, no es necesario utilizar las
llaves dobles. En su lugar, puedes pasar la variable o expresión directamente utilizando la sintaxis de atributos
de Vue.js (con el prefijo :).

--}}

<x-mail::button :url="route('contact-shares.index')">
See Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
