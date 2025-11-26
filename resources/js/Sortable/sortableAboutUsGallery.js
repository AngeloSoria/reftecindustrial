import Sortable from "sortablejs";

export function initSortableAboutUsGallery() {
    const el = document.getElementById("sortable-container_about_gallery");
    let sortable = null;
    let initialOrder = [];

    if (el) {
        sortable = Sortable.create(el, {
            animation: 150,
            handle: ".drag-handle",
            draggable: "li", // ✨ Only make <li> elements draggable
            dataIdAttr: "data-id",
            filter: 'template',
            preventOnFilter: false,
            onEnd: (evt) => {
                if (evt.oldIndex === evt.newIndex) return;

                const order = sortable.toArray();
                window.dispatchEvent(new CustomEvent("about_us_gallery_sorted", {
                    detail: { order, oldIndex: evt.oldIndex, newIndex: evt.newIndex }
                }));
            },
        });

        // custom id
        sortable.id = "sortable_AboutUsGallery";

        // Replace the queueMicrotask section with:
        setTimeout(() => {
            initialOrder = [...el.querySelectorAll('li[data-id]')].map(li => li.dataset.id);
        }, 100); // Give Alpine more time to render

        // save initialOrder
        window.addEventListener('sortable_set_initialOrder', (e) => {
            if (!e.detail?.sortableObject) return;
            if (e.detail.sortableObject.id !== sortable.id) return;
            if (!e.detail.initialOrder) return;

            // from Proxy Array into normal Array
            initialOrder = Array.from(e.detail.initialOrder);
        });
    }

    function resetOrder() {
        if (!sortable || initialOrder.length === 0) return;

        // Get only <li> elements (not templates)
        const liChildren = [...el.querySelectorAll('li[data-id]')];

        // Create a map for quick lookup
        const elementMap = new Map();
        liChildren.forEach(li => {
            elementMap.set(li.dataset.id, li);
        });

        // Temporarily disable sortable
        sortable.option("disabled", true);
        const prevAnimation = sortable.option("animation");
        sortable.option("animation", 0);

        // Remove all <li> elements first
        liChildren.forEach(li => li.remove());

        // Re-insert in the correct order by appending to the container
        // This ensures they appear in the order of the initialOrder array
        initialOrder.forEach(id => {
            const element = elementMap.get(id);
            if (element) {
                el.appendChild(element); // ✨ Simply append - they'll be added in order
            }
        });

        // Restore sortable settings
        sortable.option("animation", prevAnimation);
        sortable.option("disabled", false);

        // console.log("Reset done. Current order:", sortable.toArray());

        const order = sortable.toArray();
        window.dispatchEvent(new CustomEvent("about_us_gallery_sorted", {
            detail: { order }
        }));
    }

    // Listen for external event to reset order
    document.addEventListener('sortable_resetOrder', (e) => {
        if (!e.detail?.sortableObject) return;
        if (e.detail.sortableObject.id !== sortable.id) return;
        resetOrder();
    });

    // Expose sortable object
    window.dispatchEvent(new CustomEvent("sortable_object_gallery", {
        detail: { sortableObject: sortable }
    }));
}
