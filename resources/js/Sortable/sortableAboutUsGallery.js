import Sortable from "sortablejs";

export function initSortableAboutUsGallery() {
    const el = document.getElementById("sortable-container_about_gallery");

    if (el) {
        Sortable.create(el, {
            animation: 150,
            handle: ".drag-handle", // optional: use a handle icon or area
            onEnd: (evt) => {
                if(evt.oldIndex === evt.newIndex) { return }

                console.log("Old index:", evt.oldIndex);
                console.log("New index:", evt.newIndex);

                // Example: send new order to backend
                const order = Array.from(el.children).map(li => li.dataset.id);
                console.log("New order:", order);


                // axios.post("/update-order", { order })
                //     .then(res => console.log("Saved:", res.data))
                //     .catch(err => console.error(err));
            },
        });
    }
}
