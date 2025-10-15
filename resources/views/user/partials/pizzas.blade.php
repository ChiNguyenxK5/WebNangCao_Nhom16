<section class="pizzas">
    <div class="container">
        <h2 class="section-title">Top Recomments</h2>

        <div class="pizza-grid">
            @forelse ($pizzas as $pizza)
                <div class="pizza-card">
                    <img src="{{ asset($pizza->image ?? 'uploads/default-pizza.jpg') }}" alt="{{ $pizza->name }}">
                    <div class="pizza-info">
                        <h3>{{ $pizza->name }}</h3>
                        <p class="pizza-type">{{ ucfirst($pizza->type) }} • {{ $pizza->capacity }} người</p>
                        <p class="pizza-desc">{{ Str::limit($pizza->description, 100) }}</p>
                        <p class="pizza-price">{{ number_format($pizza->price) }}đ / đêm</p>

                        @if ($pizza->available)
                            <button class="btn-book">Đặt Pizza</button>
                        @else
                            <span class="pizza-status">Hết Pizza</span>
                        @endif
                    </div>
                </div>
            @empty
                <p>Hiện chưa có pizza nào được đăng.</p>
            @endforelse
        </div>
    </div>
</section>

<style>
.pizza-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}
.pizza-card {
    border: 1px solid #eee;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: 0.3s;
}
.pizza-card:hover { transform: scale(1.02); }
.pizza-card img { width: 100%; height: 180px; object-fit: cover; }
.pizza-info { padding: 15px; }
.pizza-price { color: #e63946; font-weight: bold; margin: 10px 0; }
.btn-book {
    background: #1d3557;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
.btn-book:hover { background: #457b9d; }
.pizza-status {
    display: inline-block;
    padding: 8px 12px;
    background: #ccc;
    border-radius: 8px;
}
</style>
