import Sortable from "sortablejs";

export function initSortableAboutUsGallery() {
    const el = document.getElementById("sortable-container_about_gallery");
    let sortable = null;
    let initialOrder = [];

    if (el) {
        sortable = Sortable.create(el, {
            animation: 150,
            handle: ".drag-handle",
            dataIdAttr: "data-id",
            onEnd: (evt) => {
                if (evt.oldIndex === evt.newIndex) return;

                const order = sortable.toArray();
                // console.log("New order:", order);

                // 🔥 Dispatch Alpine event
                window.dispatchEvent(new CustomEvent("about_us_gallery_sorted", {
                    detail: {
                        order,
                        oldIndex: evt.oldIndex,
                        newIndex: evt.newIndex
                    }
                }));
            },
        });

        // Save original order
        initialOrder = sortable.toArray();
    }

    // return functions it can be triggered from outside
    return {
        resetOrder() {
            if (sortable) {
                sortable.sort(initialOrder);
            }
        },

        saveNewOrder() {
            if (sortable) {
                initialOrder = sortable.toArray(); // update baseline
                console.log("Saved new baseline:", initialOrder);
            }
        }
    };
}
