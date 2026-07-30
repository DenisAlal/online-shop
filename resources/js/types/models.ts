export interface Category {
    id: number;
    name: string;
    slug: string;
    description: string | null;
    parent_id: number | null;
    parent: Category | null;
    products: { id: number; name: string }[];
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    category_id: number | null;
    name: string;
    slug: string;
    description: string | null;
    price: number;
    discount: number;
    stock_quantity: number;
    is_active: boolean;
    category: Category | null;
    image: string | null;
    created_at: string;
    updated_at: string;
}

export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}
