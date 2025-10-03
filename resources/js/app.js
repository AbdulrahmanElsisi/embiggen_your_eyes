import './bootstrap';


// Example with fetch
async function searchNASA(query) {
    const res = await fetch("/nasa/search", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ query })
    });
    const data = await res.json();
    console.log(data);
    // هنا ممكن تستخدم مكتبة react-compare-image لو React
}

// Example usage:
searchNASA("Amazon forest 2000 vs 2020");


async function searchImage(query, file) {
  const formData = new FormData();
  formData.append("query", query);
  formData.append("image", file);

  const res = await fetch("/image/search", {
    method: "POST",
    body: formData
  });

  const data = await res.json();
  console.log(data);
}

// مثال:
// user يرفع صورة + يكتب query "river"
