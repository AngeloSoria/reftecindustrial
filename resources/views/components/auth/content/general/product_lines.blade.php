<h2 class="text-xl font-bold mb-2">Product Lines</h2>
<p>Display your different product categories or featured products here.</p>

<button
@click="$dispatch('open-modal', {'id':'exampleModal'})"
class="cursor-pointer px-4 py-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 transition-colors">
Click Me!
</button>

<x-auth.modal.add_product_line title="Add new Product Line"/>
