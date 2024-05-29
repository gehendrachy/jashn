<table id="products-table" class="table table-striped table-bordered wrap" style="margin-left: 0px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>SN.</th>
                                                <th>{{ __('Product')}}</th>
                                                <th>{{ __('SKU')}}</th>
                                                <th>{{ __('Variation')}}</th>
                                                <th>{{ __('Price')}}</th>
                                                <th>{{ __('Stock')}}</th>
                                                <th>{{ __('Created')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $key => $product)
                                            
                                            @php 
                                                $product_variation_sizes = $product->product_sizes;
                                            @endphp
                                            

                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center" width="20%">

                                                    @if($product->display == 1)
                                                        <a target="_blank" href="{{ route('product-details',['slug' => $product->slug]) }}">{{ $product->title }}</a><br>
                                                        <i style="color: green;" class="fa fa-eye"></i>
                                                    
                                                    @else
                                                        {{ $product->title }}<br>
                                                        <i style="color: red;" class="fa fa-eye-slash"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            <a target="_blank" href="{{ route('product-details', ['slug' => $product->slug, 'c' => $product_size->product_color->color->code]) }}">{{ $product_size->sku }} <i class="fa fa-sm fa-external-link-alt"></i></a>
                                                        </p>
                                                    @endforeach
                                                    
                                                </td>
                                                
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        
                                                        <p style="font-size: 12px;">
                                                            {{ $product_size->size->name }}, {{ $product_size->product_color->color->title }}
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            NRs.{{ $product_size->price }}
                                                        </p>
                                                    @endforeach                                                        
                                                </td>
                                                <td class="text-center">
                                                    @foreach($product_variation_sizes as $variation_key => $product_size)
                                                        <p style="font-size: 12px;">
                                                            {{ $product_size->quantity }}
                                                            @if($product_size->preorder == 1)
                                                                ({{ $product_size->preorder_stock_limit }})
                                                            @endif
                                                        </p>
                                                    @endforeach
                                                </td>
                                                <td class="text-center" width="5%">
                                                    <p style="font-size: 12px;">
                                                        {{ date('jS F, Y', strtotime($product->created_at)) }}<br>
                                                        {{ date('h:i:s A', strtotime($product->created_at)) }}
                                                    </p>
                                                    @if($product->created_at != $product->updated_at && $product->updated_at != NULL)
                                                    <p style="font-size: 12px;">
                                                        Updated At
                                                        <small>{{ date('jS F, Y', strtotime($product->updated_at)) }}<br>
                                                        {{ date('h:i:s A', strtotime($product->updated_at)) }}</small>
                                                    </p>
                                                    @endif

                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>