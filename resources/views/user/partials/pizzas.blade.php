<!-- filepath: resources/views/user/partials/pizzas.blade.php -->
<section class="pizzas">
    <div class="container">
        <h2 class="section-title"></h2>

        <!-- Filter Topping -->
        <div class="pizza-filter">
            <a href="{{ url('/?topping=all') }}" class="filter-btn {{ $selectedTopping === 'all' ? 'active' : '' }}">
                🍕 Tất Cả
            </a>
            @foreach($toppings as $topping)
                <a href="{{ url('/?topping=' . $topping) }}" class="filter-btn {{ $selectedTopping === $topping ? 'active' : '' }}">
                    @switch($topping)
                        @case('Cheese')
                            🧀 Phô mai
                            @break
                        @case('Pepperoni')
                            🍖 Xúc xích
                            @break
                        @case('Veggie')
                            🥬 Rau củ
                            @break
                        @case('Seafood')
                            🦐 Hải sản
                            @break
                        @case('Meat')
                            🥩 Thịt
                            @break
                        @default
                            🍕 {{ $topping }}
                    @endswitch
                </a>
            @endforeach
        </div>

        <div class="pizza-grid">
            @forelse ($pizzas as $pizza)
                <div class="pizza-card">
                    <img src="{{ asset($pizza->image_url ?? 'uploads/default-pizza.jpg') }}" alt="{{ $pizza->name }}">
                    <div class="pizza-info">
                        <h3>{{ $pizza->name }}</h3>
                        <p class="pizza-type">
                            @if($pizza->topping)
                                {{ $pizza->topping }} • 
                            @endif
                            {{ $pizza->size ?? 'Medium' }}
                        </p>
                        <p class="pizza-desc">{{ Str::limit($pizza->description, 100) }}</p>
                        <p class="pizza-price">{{ number_format($pizza->price) }} VND</p>

                        @if ($pizza->available)
                            <button class="btn-book">Đặt Pizza</button>
                        @else
                            <span class="pizza-status">Hết Pizza</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Không có pizza nào với topping "{{ $selectedTopping }}"</p>
                    <a href="{{ url('/') }}" class="btn-back">Xem tất cả pizza</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
.pizza-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
    justify-content: center;
}

.filter-btn {
    padding: 10px 20px;
    background: white;
    border: 2px solid #ff6b35;
    border-radius: 25px;
    text-decoration: none;
    color: #ff6b35;
    font-weight: 600;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.filter-btn:hover,
.filter-btn.active {
    background: #ff6b35;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
}

.pizza-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.pizza-card {
    border: 1px solid #eee;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    background: white;
}

.pizza-card:hover { 
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.pizza-card img { 
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
}

.pizza-info { 
    padding: 20px; 
}

.pizza-info h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.2em;
}

.pizza-type {
    color: #666;
    font-size: 0.9em;
    margin-bottom: 10px;
}

.pizza-desc {
    color: #777;
    font-size: 0.9em;
    line-height: 1.4;
    margin-bottom: 15px;
}

.pizza-price { 
    color: #e63946; 
    font-weight: bold; 
    font-size: 1.1em;
    margin: 15px 0; 
}

.btn-book {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-book:hover { 
    background: linear-gradient(135deg, #e55a2b, #e8841a);
    transform: translateY(-2px);
}

.pizza-status {
    display: inline-block;
    padding: 10px 20px;
    background: #ccc;
    color: white;
    border-radius: 25px;
    font-weight: 600;
    width: 100%;
    text-align: center;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
}

.empty-state p {
    font-size: 1.2em;
    color: #666;
    margin-bottom: 20px;
}

.btn-back {
    display: inline-block;
    padding: 12px 25px;
    background: #ff6b35;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
}

@media (max-width: 768px) {
    .pizza-filter {
        justify-content: flex-start;
        overflow-x: auto;
        padding: 10px 0;
    }
    
    .filter-btn {
        flex-shrink: 0;
    }
}
</style>